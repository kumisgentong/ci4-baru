<?php namespace App\Controllers;

use \App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class NewsAdmin extends BaseController
{
	public function index()
	{
        $news = new NewsModel();
        $data['newses'] = $news->findAll();
		echo view('admin_list_news', $data);
    }

    //--------------------------------------------------------------------------
    
    public function preview($id)
	{
		$news = new NewsModel();
		$data['news'] = $news->where('id', $id)->first();
		
		if(!$data['news']){
			throw PageNotFoundException::forPageNotFound();
		}
		echo view('news_detail', $data);
    }

    //--------------------------------------------------------------------------
    
    public function create()
    {
        // lakukan validasi
        $validation =  \Config\Services::validation();
        $validation->setRules(['title' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();

        // jika data valid, simpan ke database
        if($isDataValid){
            $news = new NewsModel();
            $news->insert([
                "title" => $this->request->getPost('title'),
                "content" => $this->request->getPost('content'),
                "status" => $this->request->getPost('status'),
                "slug" => url_title($this->request->getPost('title'), '-', TRUE)
            ]);
            return redirect('admin/news');
        }
		
        // tampilkan form create
        echo view('admin_create_news');
    }

    //--------------------------------------------------------------------------

    public function edit($id)
    {
        // ambil artikel yang akan diedit
        $news = new NewsModel();
        $data['news'] = $news->where('id', $id)->first();
        
        // lakukan validasi data artikel
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'id' => 'required',
            'title' => 'required'
        ]);
        $isDataValid = $validation->withRequest($this->request)->run();
        // jika data vlid, maka simpan ke database
        if($isDataValid){
            $news->update($id, [
                "title" => $this->request->getPost('title'),
                "content" => $this->request->getPost('content'),
                "status" => $this->request->getPost('status')
            ]);
            return redirect('admin/news');
        }

        // tampilkan form edit
        echo view('admin_edit_news', $data);
    }

    //--------------------------------------------------------------------------

	public function delete($id){
        $news = new NewsModel();
        $news->delete($id);
        return redirect('admin/news');
    }

    public function uploadimage()
    {
        echo "TES:".var_dump($_POST);
       // echo base_url()."<script>alert ('mecek');</script>";
        // Define file upload path 
        $upload_dir = array( 
            'img'=> 'uploads/images/', 
        ); 
         
        // Allowed image properties  
        $imgset = array( 
            'maxsize' => 20000, 
            'maxwidth' => 1280, 
            'maxheight' => 1280, 
            'minwidth' => 10, 
            'minheight' => 10, 
            'type' => array('bmp', 'gif', 'jpg', 'jpeg', 'png'), 
        ); 
         
        // If 0, will OVERWRITE the existing file 
        define('RENAME_F', 1); 
         
        /** 
         * Set filename 
         * If the file exists, and RENAME_F is 1, set "img_name_1" 
         * 
         * $p = dir-path, $fn=filename to check, $ex=extension $i=index to rename 
         */ 
        function setFName($p, $fn, $ex, $i){ 
            if(RENAME_F ==1 && file_exists($p .$fn .$ex)){ 
                return setFName($p, F_NAME .'_'. ($i +1), $ex, ($i +1)); 
            }else{ 
                return $fn .$ex; 
            } 
        } 
         
        $re = ''; 
        if(isset($_FILES['upload']) && strlen($_FILES['upload']['name']) > 1) { 
         
            define('F_NAME', preg_replace('/\.(.+?)$/i', '', basename($_FILES['upload']['name'])));   
         
            // Get filename without extension 
            $sepext = explode('.', strtolower($_FILES['upload']['name'])); 
            $type = end($sepext);    /** gets extension **/ 
             
            // Upload directory 
            $upload_dir = in_array($type, $imgset['type']) ? $upload_dir['img'] : $upload_dir['audio']; 
            $upload_dir = trim($upload_dir, '/') .'/'; 
                
            // Validate file type 
            if(in_array($type, $imgset['type'])){ 
                // Image width and height 
                list($width, $height) = getimagesize($_FILES['upload']['tmp_name']); 
         
                if(isset($width) && isset($height)) { 
                    if($width > $imgset['maxwidth'] || $height > $imgset['maxheight']){ 
                        $re .= '\\n Width x Height = '. $width .' x '. $height .' \\n The maximum Width x Height must be: '. $imgset['maxwidth']. ' x '. $imgset['maxheight']; 
                    } 
         
                    if($width < $imgset['minwidth'] || $height < $imgset['minheight']){ 
                        $re .= '\\n Width x Height = '. $width .' x '. $height .'\\n The minimum Width x Height must be: '. $imgset['minwidth']. ' x '. $imgset['minheight']; 
                    } 
         
                    if($_FILES['upload']['size'] > $imgset['maxsize']*1000){ 
                        $re .= '\\n Maximum file size must be: '. $imgset['maxsize']. ' KB.'; 
                    } 
                } 
            }else{ 
                $re .= 'The file: '. $_FILES['upload']['name']. ' has not the allowed extension type.'; 
            } 
             
            // File upload path 
            $f_name = setFName($_SERVER['DOCUMENT_ROOT'] .'/'. $upload_dir, F_NAME, ".$type", 0); 
            $uploadpath = $upload_dir . $f_name; 
         
            // If no errors, upload the image, else, output the errors 
            if($re == ''){ 
                if(move_uploaded_file($_FILES['upload']['tmp_name'], $uploadpath)) { 
                    $CKEditorFuncNum = $_GET['CKEditorFuncNum']; 
                    $url = 'http://'.$_SERVER['HTTP_HOST'].'/'.'ckeditor/'. $upload_dir . $f_name; 
                    $msg = F_NAME .'.'. $type .' successfully uploaded: \\n- Size: '. number_format($_FILES['upload']['size']/1024, 2, '.', '') .' KB'; 
                    $re = in_array($type, $imgset['type']) ? "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>":'<script>var cke_ob = window.parent.CKEDITOR; for(var ckid in cke_ob.instances) { if(cke_ob.instances[ckid].focusManager.hasFocus) break;} cke_ob.instances[ckid].insertHtml(\' \', \'unfiltered_html\'); alert("'. $msg .'"); var dialog = cke_ob.dialog.getCurrent();dialog.hide();</script>'; 
                }else{ 
                    $re = '<script>alert("Unable to upload the file")</script>'; 
                } 
            }else{ 
                $re = '<script>alert("'. $re .'")</script>'; 
            } 
        } 
         
        // Render HTML output 
        @header('Content-type: text/html; charset=utf-8'); 
        echo $re;
        // $age = array("url"=>"localhost/ci4_new/uploads/images/pijarstudio.jpg");
        // echo json_encode($age);
    }
}