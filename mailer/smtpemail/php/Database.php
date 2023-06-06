<?php

session_start();
include_once "db.php";
require_once "classes/Category.php";
require_once "classes/Subcategory.php";
require_once "classes/Post.php";


$useragent = $_SERVER['HTTP_USER_AGENT'];

if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))){
    $dtype = 'm';
}else{
    $dtype = 'd';
}

class Database {

    private $mysql;

    public function __construct() {
        $this->mysql = new mysqli(HOST, USER, PASS, DB);
        $this->mysql->query('SET NAMES utf8');
    }

    public function __destruct() {
        $this->mysql->close();
    }

    /* ------CATEGORIES-------- */

    public function getCategoryById($id) {
        $id = (int) $id;
        $rs = $this->mysql->query("select * from categories where id=" . $id);
        if (!isset($rs))
            die("Bad");
        if (empty($rs))
            die("Bad");

        $row = $rs->fetch_assoc();
        $category = new Category();
        $category->setCategory($row);

        $rs = $this->mysql->query("select * from subcategories where id_cat=" . $id);
        $subcategories = array();
        while (($row = $rs->fetch_assoc()) != false) {
            $subcategory = new Subcategory();
            $subcategory->setSubCategory($row);
            $subcategories[] = $subcategory;
        }
        $category->setSub($subcategories);

        return $category;
    }

    public function getCategoryByEngName($eng_name) {
        $eng_name = $this->mysql->real_escape_string($eng_name);
        $rs = $this->mysql->query("select * from categories where eng_name='$eng_name'");
        if (!isset($rs))
            die("Bad");
        if (empty($rs))
            die("Bad");

        $row = $rs->fetch_assoc();
        $category = new Category();
        $category->setCategory($row);

        return $category;
    }

    public function getCategories() {
        $rs = $this->mysql->query("select * from categories");

        $categories = array();
        while (($row_cat = $rs->fetch_assoc()) != false) {
            $category = new Category();
            $category->setCategory($row_cat);
            $subcategories = $this->getSubcatByIdCat($category->getId());
            $category->setSub($subcategories);
            $categories[] = $category;
        }

        return $categories;
    }

    /* -------------Subcategory------------------- */

    public function getSubcatByIdCat($id) {
        $id = (int) $id;
        $rs = $this->mysql->query("select * from subcategories where id_cat=" . $id);
        if (!isset($rs))
            die("Bad");
        if (empty($rs))
            die("Bad");

        $subcategories = array();
        while (($row = $rs->fetch_assoc()) != false) {
            $subcategory = new Subcategory();
            $subcategory->setSubCategory($row);
            $subcategories[] = $subcategory;
        }

        return $subcategories;
    }

    public function getSubcatByEngName($eng_name) {
        $eng_name = $this->mysql->real_escape_string($eng_name);
        $rs = $this->mysql->query("select * from subcategories where eng_name='$eng_name'");
        if (!isset($rs))
            die("Bad");
        if (empty($rs))
            die("Bad");

        $row = $rs->fetch_assoc();
        $subcategory = new Subcategory();
        $subcategory->setSubCategory($row);



        return $subcategory;
    }

    public function getSubById($id) {
        $id = (int) $id;
        $rs = $this->mysql->query("select * from subcategories where id=" . $id);
        if (!isset($rs))
            die("Bad");
        if (empty($rs))
            die("Bad");

        $row = $rs->fetch_assoc();
        $sub = new Subcategory();
        $sub->setSubCategory($row);

        return $sub;
    }

    /* ------POSTS------- */

    public function getPostById($id) {
        $id = (int) $this->mysql->real_escape_string($id);
        $rs = $this->mysql->query("select * from posts where id=" . $id);
        if (!isset($rs))
            die("Bad");
        if (empty($rs))
            die("Bad");

        $row = $rs->fetch_assoc();
        $post = new Post();
        $post->setPost($row);

        return $post;
    }

    public function getPostsAdmin($page, $cat, $sub) {
        $page = intval($page);
        $limit = 40;
        $offset = ($page - 1) * $limit;

        if ($sub == 0) {
            $rs = $this->mysql->query("SELECT * FROM `posts` where id_cat=$cat ORDER BY sort ASC LIMIT $offset, $limit");
            if (!isset($rs))
                die("Bad");
            if (empty($rs))
                die("Bad");
        }else {
            $rs = $this->mysql->query("SELECT * FROM `posts` where id_subcat=$sub ORDER BY sort ASC LIMIT $offset, $limit");
            if (!isset($rs))
                die("Bad");
            if (empty($rs))
                die("Bad");
        }

        $posts = array();
        while (($row = $rs->fetch_assoc()) != false) {
            $post = new Post();
            $post->setPost($row);
            $posts[] = $post;
        }
        return $posts;
    }

    public function pagesResultPostsAdmin($cat, $sub) {
        if ($sub == 0) {
            $res = $this->mysql->query("select COUNT(*) as cnt from posts where id_cat=$cat")->fetch_assoc();
        } else {
            $res = $this->mysql->query("select COUNT(*) as cnt from posts where id_subcat=$sub")->fetch_assoc();
        }
        return $res['cnt'];
    }

    public function addPostAdmin($data) {
        $rs = $this->mysql->query("Insert into posts (`nazva`, `description`, `img`, `text`,
    `id_cat`,`id_subcat`)  VALUES ('{$data['nazva']}', '{$data['description']}', '{$data['img']}', 
         '{$data['text']}', {$data['cat']}, {$data['sub']})");
        return $rs;
    }

    public function updatePostAdmin($data) {
        $rs = $this->mysql->query("UPDATE posts SET nazva='{$data['nazva']}', 
          description='{$data['description']}',  text='{$data['text']}', sort={$data['sort']}
           WHERE id={$data['id']}");
        return $rs;
    }

    public function changeMainPhotoPost($post) {
        $this->mysql->query("UPDATE posts SET img='{$post->getImg()}' where id={$post->getId()}");
    }

    public function deletePostAdmin($id) {
        $id = intval($id);
        $rs = $this->mysql->query("DELETE FROM posts WHERE id=$id");
        return $rs;
    }

    /* =====================CLIENT=============================== */

    public function getSidePostsByEng($eng_name) {
        $eng_name = $this->mysql->real_escape_string($eng_name);
        $subcategory = $this->getSubcatByEngName($eng_name);

        $rs = $this->mysql->query("select * from posts where id_cat={$subcategory->getIdCat()}
        and id_subcat={$subcategory->getId()} ORDER BY sort ASC");

        $posts = array();
        while (($row = $rs->fetch_assoc()) != false) {
            $post = new Post();
            $post->setPost($row);
            $posts[] = $post;
        }
        return $posts;
    }

    /* --------------PRESS----------------- */

    public function getPress($page, $side) {
        $page = intval($page);
        $limit = 3;
        $offset = ($page - 1) * $limit;

        switch ($side) {
            case "ourcompany-press":
                $rs = $this->mysql->query("select * from posts where id_cat=5 and id_subcat=20 ORDER BY sort ASC LIMIT $offset, $limit");
                $res_cnt = $this->mysql->query("select COUNT(*) as cnt from posts where id_cat=5 and id_subcat=20")->fetch_assoc();
                break;
            case "restorations-press":
                $rs = $this->mysql->query("select * from posts where id_cat=5 and id_subcat=21 ORDER BY sort ASC LIMIT $offset, $limit");
                $res_cnt = $this->mysql->query("select COUNT(*) as cnt from posts where id_cat=5 and id_subcat=21")->fetch_assoc();
                break;
            case "commercial-press":
                $rs = $this->mysql->query("select * from posts where id_cat=5 and id_subcat=22 ORDER BY sort ASC LIMIT $offset, $limit");
                $res_cnt = $this->mysql->query("select COUNT(*) as cnt from posts where id_cat=5 and id_subcat=22")->fetch_assoc();
                break;
            default:
                $rs = $this->mysql->query("select * from posts where id_cat=5 ORDER BY sort ASC LIMIT $offset, $limit");
                $res_cnt = $this->mysql->query("select COUNT(*) as cnt from posts where id_cat=5")->fetch_assoc();
        }

        $pages = intval($res_cnt['cnt']) / $limit;

        $posts = array('posts' => array(), 'pages' => $pages);
        while (($row = $rs->fetch_assoc()) != false) {
            $post = new Post();
            $post->setPost($row);
            $posts['posts'][] = $post;
        }

        return $posts;
    }

    public function getPressJson($page) {
        $page = intval($page);
        $limit = 3;
        $offset = ($page - 1) * $limit;

        $rs = $this->mysql->query("select * from posts where id_cat=5 ORDER BY sort ASC LIMIT $offset, $limit");
        $posts = array();
        while (($row = $rs->fetch_assoc()) != false) {
            $post = array();
            $post['id'] = intval($row['id']);
            $post['id_cat'] = intval($row['id_cat']);
            $post['id_subcat'] = intval($row['id_subcat']);
            $post['nazva'] = $row['nazva'];
            $post['description'] = $row['description'];
            $post['img'] = $row['img'];
            $post['datee'] = $row['datee'];
            $posts[] = $post;
        }

        $ret = json_encode($posts);
        return $ret;
    }

    public function getRecentPressByNav($nav) {

        switch ($nav) {
            case "ourcompany":
                $rs = $this->mysql->query("select * from posts where id_cat=5 and id_subcat=20 ORDER BY sort ASC LIMIT 3");
                break;
            case "restorations":
                $rs = $this->mysql->query("select * from posts where id_cat=5 and id_subcat=21 ORDER BY sort ASC LIMIT 3");
                break;
            case "commercial":
                $rs = $this->mysql->query("select * from posts where id_cat=5 and id_subcat=22 ORDER BY sort ASC LIMIT 3");
                break;
            default:
                $rs = $this->mysql->query("select * from posts where id_cat=5 ORDER BY sort ASC LIMIT 3");
        }

        $posts = array();
        while (($row = $rs->fetch_assoc()) != false) {
            $post = new Post();
            $post->setPost($row);
            $posts[] = $post;
        }

        return $posts;
    }

}
