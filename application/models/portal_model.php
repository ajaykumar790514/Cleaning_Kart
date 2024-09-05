<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class portal_model extends CI_Model
{
    public function news_data($limit=null,$start=null)
	{
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*')
        ->from('news t1');
		if($limit!=null)
            return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();
	}
    public function enquiry_data($limit=null,$start=null)
	{
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*')
        ->from('feedback t1');
		if($limit!=null)
            return $this->db->get()->result();
        else
            return $this->db->get()->num_rows();
	}
    public function add_news($data)
    {
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'news/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['photo']['name'])) {
            //upload images
            $_FILES['photos']['name'] = $_FILES['photo']['name'];
            $_FILES['photos']['type'] = $_FILES['photo']['type'];
            $_FILES['photos']['tmp_name'] = $_FILES['photo']['tmp_name'];
            $_FILES['photos']['size'] = $_FILES['photo']['size'];
            $_FILES['photos']['error'] = $_FILES['photo']['error'];

            if ($this->upload->do_upload('photos')) {
                $image_data = $this->upload->data();

                $fileName = "news/" . $image_data['file_name'];
            }
            $data['photo'] = $fileName;
        } else {
            $data['photo'] = "";
        }
        if (!empty($fileName))
        {  
            $insert_query = $this->db->insert('news', $data);
            $insert_id = $this->db->insert_id();
            $news_data          = $this->portal_model->get_row_data1('news','id',$insert_id);
            $url = str_replace(" ","-","https://www.shopzone247.com/news-detail/".$insert_id."/".$news_data->title);
            $users = simplexml_load_file(SITEMAP_URL);
            $user = $users->addChild('url');
            $user->addChild('id', $insert_id);
            $user->addChild('loc', $url);
            $user->addChild('lastmod', date('Y-m-d'));
            $user->addChild('priority', $news_data->priority);
            // Save to file
            // file_put_contents('files/members.xml', $users->asXML());
            // Prettify / Format XML and save
            $dom = new DomDocument();
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($users->asXML());
            $dom->save(SITEMAP_URL);
            return $insert_query;
        }
    }
    public function edit_news($data,$id)
    {
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'news/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['photo']['name'])) {
            //upload images
            $_FILES['photos']['name'] = $_FILES['photo']['name'];
            $_FILES['photos']['type'] = $_FILES['photo']['type'];
            $_FILES['photos']['tmp_name'] = $_FILES['photo']['tmp_name'];
            $_FILES['photos']['size'] = $_FILES['photo']['size'];
            $_FILES['photos']['error'] = $_FILES['photo']['error'];

            if ($this->upload->do_upload('photos')) {
                $image_data = $this->upload->data();

                $fileName = "news/" . $image_data['file_name'];
                $data['photo'] = $fileName;
            }
        }
        if (!empty($fileName))    
        {
            $data1['images'] = $this->portal_model->get_row_data1('news','id',$id);
            if(is_file(DELETE_PATH.$data1['images']->photo))
            {
                unlink(DELETE_PATH.$data1['images']->photo);
            }
        }
        //update xml
        $users = simplexml_load_file(SITEMAP_URL);
        $flag = "0";
        $url = str_replace(" ","-","https://www.shopzone247.com/news-detail/".$id."/".$data['title']);
		foreach($users->url as $user){
			if($user->id == $id){
                if($user->id == $id)
                {
                    $flag = '1';
                }
				$user->loc = $url;
				$user->lastmod = date('Y-m-d');
				$user->priority = $data['priority'];
				break;
			}
		}
        if($flag == '1') 
        {
            file_put_contents(SITEMAP_URL, $users->asXML());
        }
        else
        {
            $user = $users->addChild('url');
            $user->addChild('id', $id);
            $user->addChild('loc', $url);
            $user->addChild('lastmod', date('Y-m-d'));
            $user->addChild('priority', $data['priority']);
            $dom = new DomDocument();
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($users->asXML());
            $dom->save(SITEMAP_URL);
        }

            return $this->db->where('id', $id)->update('news', $data); 

    }
    public function delete_news($id)
    {
        $data1['images'] = $this->portal_model->get_row_data1('news','id',$id);
        if(is_file(DELETE_PATH.$data1['images']->photo))
        {
            unlink(DELETE_PATH.$data1['images']->photo);
        }
        //delete xml
        $users = simplexml_load_file(SITEMAP_URL);

        //we're are going to create iterator to assign to each user
        $index = 0;
        $i = 0;
        
        foreach($users->url as $user){
            if($user->id == $id){
                $index = $i;
                break;
            }
            $i++;
        }
        
        unset($users->url[$index]);
        file_put_contents(SITEMAP_URL, $users->asXML());
		return $this->db->where('id', $id)->delete('news');

    }

}
?>