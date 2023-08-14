<?php
require_once("setup.php");
function formatNumber($number) {
    if ($number >= 1000000000) {
        return number_format($number / 1000000000, 2) . 'B';
    } elseif ($number >= 1000000) {
        return number_format($number / 1000000, 2) . 'M';
    } elseif ($number >= 1000) {
        return number_format($number / 1000, 2) . 'K';
    } else {
        return $number;
    }

}
function getId($getName){
    $sub_cat_id = $_GET["$getName"];
    $sub_cat_id = explode('-',$sub_cat_id);
    $sub_cat_id = end($sub_cat_id);
    return $sub_cat_id;
}

//link genarate 
function linkGenarate(){
    if(isset($_GET["categories"])){
        $v= $_GET["categories"];
        $val = "&categories=$v";
        
    }elseif(isset($_GET["subcat"])){
        $v= $_GET["subcat"];
        $val = "&subcat=$v";
        
    }else{
        $val='';
    }
    return $val;
}
$link = linkGenarate();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Welcome to our comprehensive resource hub for web designers, developers, and enthusiasts of PHP and WordPress. Explore expert tips, tutorials, and best practices to elevate your web projects to the next level. Whether you're a seasoned developer or just starting out, our content is designed to help you create stunning, responsive, and high-performance websites that excel in both design and functionality.">
    <meta name="keywords" content="web design, web development, PHP, WordPress, tutorials, best practices, responsive design, performance optimization, coding, website creation, web projects">
    <meta name="robots" content="index,follow">
    <link rel="canonical" href="https://www.example.com/seo-example">
    <meta property="og:title" content="Code Chronicles: Insights, Tutorials, and Musings on Programming">
    <meta property="og:description" content="Welcome to our comprehensive resource hub for web designers, developers, and enthusiasts of PHP and WordPress. Explore expert tips, tutorials, and best practices to elevate your web projects to the next level. Whether you're a seasoned developer or just starting out, our content is designed to help you create stunning, responsive, and high-performance websites that excel in both design and functionality.">
    <meta property="og:image" content="https://www.example.com/images/example.jpg">
    <meta property="og:url" content="https://www.example.com/seo-example">
    <title>Web Design and Development Hub | PHP & WordPress Resources</title>
        <!-- font icons -->
        <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    
    <!-- Bootstrap + main styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

	<link rel="stylesheet" href="assets/css/johndoe.css?v=1212">
    <style>
        .page{
            text-align:center;
            margin-bottom:50px;
        }
        .page a{
            padding:5px 8px;
            border:1px solid blue;
            margin:3px;
        }
        .active{
            background-color:black;
            color:White;
        }
    </style>

</head>
<body>
<style>
        .brand{
            display:none;
        }

    </style>
    <?php
    
        require_once("menu.php");
    ?>


 <section>
        <div class="row m-4">

            <div class="col-lg-4 col-md-4 col-sm-12 show-another">
            <ul>
                         
                               <a href="blog" class="text-success">ALL</a> 
                            
    </ul>

            <?php 
                $select = "SELECT * FROM category";
                $comp = mysqli_query($connection,$select);
                while($data=mysqli_fetch_assoc($comp)):
                $cat_id = $data['cat_id'];

            ?>
                    
                        <ul>
                            <li>
                               <a href="blog?categories=<?= $data['cat_name'].'-'.$data['cat_id']; ?>" class="text-success"><?= $data['cat_name']; ?></a> 
                                 <ul>
                                <?php
                                    $select1 = "SELECT * FROM sub_cat WHERE s_cat_id='$cat_id'";
                                    $comp1 = mysqli_query($connection,$select1);
                                    while($data1=mysqli_fetch_assoc($comp1)):
                               ?>
                                 <li>   <a href="blog?subcat=<?= $data1['sub_cat_name'].'-'.$data1['sub_cat_id'] ?>">  <?= $data1['sub_cat_name'] ?> </a> </li>
                                <?php endwhile ?>
                                 </ul>
                            </li>
                        </ul>
<?php endwhile; ?>
                    
            </div>

     <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="row">
        <?php
                   $limit = 5;
                   if(isset($_GET['page'])){
                       $page=$_GET['page'];
                   }else{
                       $page = 1;
                   }

                   if(isset($_GET['categories'])){
                    $cat_id = getId('categories');
                    $total_page1 = "SELECT * FROM blogs WHERE cat_id='$cat_id'";
                }elseif(isset($_GET['subcat'])){
                    $sub_cat_id = getId('subcat');
                    $total_page1 = "SELECT * FROM blogs WHERE sub_cat_id='$sub_cat_id'";
                }else{
                    $total_page1 = "SELECT * FROM blogs";
                }

                   $total_page=mysqli_num_rows(mysqli_query($connection,$total_page1));
                  
                $page_number = ceil(($total_page)/$limit); //Page Number
                   $offset = ceil(($page-1)*$limit);


            if(isset($_GET['categories'])){
                $select3 = "SELECT * FROM blogs
                INNER JOIN category ON blogs.cat_id = category.cat_id
                INNER JOIN sub_cat ON blogs.sub_cat_id = sub_cat.sub_cat_id 
                WHERE blogs.cat_id='$cat_id'
                ORDER BY blogs.blog_id DESC LIMIT $offset,$limit";
            }elseif(isset($_GET['subcat'])){
                $sub_cat_id = getId('subcat');
                $select3 = "SELECT * FROM blogs
                INNER JOIN category ON blogs.cat_id = category.cat_id
                INNER JOIN sub_cat ON blogs.sub_cat_id = sub_cat.sub_cat_id 
                WHERE blogs.sub_cat_id='$sub_cat_id'
                ORDER BY blogs.blog_id DESC LIMIT $offset,$limit";
            }else{
                $select3 = "SELECT * FROM blogs
                INNER JOIN category ON blogs.cat_id = category.cat_id
                INNER JOIN sub_cat ON blogs.sub_cat_id = sub_cat.sub_cat_id 
                ORDER BY blogs.blog_id DESC LIMIT $offset,$limit";
               
            }
            $comp3 = mysqli_query($connection,$select3);
            while($data3=mysqli_fetch_assoc($comp3)):
            
        ?>

        <!-- start -->
            <div class="col-md-6 col-sm-12 col-lg-4 p-2 shows">
                    <img src="assets/imgs/<?= $data3['blog_image']; ?>" class=" float-left img-thumbnail" alt=""/>
               
                    <p class="text-justify">
                    
                    <i class="ti-time"></i>  <?= $data3['blog_add_date']; ?>
                    <i class="ti-eye"></i>  <?= formatNumber($data3['blog_view']); ?>
                    <br>
                      <a href="blog?categories=<?= $data3['cat_name'].'-'.$data3['cat_id']; ?>" class="text-success">  <i class="ti-bookmark"></i> <?= $data3['cat_name']; ?> </a>
                        <a href="blog?subcat=<?= $data3['sub_cat_name'].'-'.$data3['sub_cat_id'] ?>"><i class="ti-bookmark-alt"></i> <?= $data3['sub_cat_name']; ?></a>
                   <a href="blogs?id=<?=$data3['blog_id']?>" class="text-dark">
                   <br>
                        <?= mb_substr($data3['blog_title'], 0, 56, 'UTF-8'); ?> .. see more
                    </p>
                    </a>
                </div>
        <!-- end -->
     <?php endwhile ?>



    </div>
</div>
</div>

<!-- pagenation satart -->
<div class="page">

<?php

            // $limit = 3;
            // if(isset($_GET['page'])){
            //     $page=$_GET['page'];
            // }else{
            //     $page = 1;
            // }
            // $total_page1 = "SELECT * FROM blogs";
            // $total_page=mysqli_num_rows(mysqli_query($connection,$total_page1));
            // $page_number = ceil(($total_page)/$limit); //Page Number
            // $offset = ($total_page-1)/$limit;
            if($page>1){
                $back=$page-1;
                echo "<a  href='blog?page=$back.$link'><</a>";
            }

            if($page>($limit/2)){
                echo "<a href='blog?page=1 $link'>1</a>";
                if($page> 3){
                    echo "....";
                }
               
            }

            if($page>3){
                $first = $page-1;
                $second = $page-2;
                echo "<a href='blog?page=$second $link'>$second</a>";
                echo "<a href='blog?page=$first $link'>$first</a>";
            }
            $c=1;
            for($i=$page;$i<=$page_number;$i++){
                if($i==$page){
                    $active="active";
                }else{
                    $active='';
                }
                if($c<$limit){
                    echo "<a class='$active' href='blog?page=$i $link'>$i</a>";
                }
                $c++;
            }

            if($page<$page_number-($limit/2)){
               
                    echo "....";  
                
                echo "<a href='blog?page=$page_number $link'>$page_number</a>";
            }

            if($page<$page_number ){
                $font=$page+1;
                echo "<a href='blog?page=$font $link'>></a>";
            }

          ?>


<!-- pagenation end -->
</div>
       
    </section>
    
    <?php
    require_once("footer.php");
?>


	<!-- core  -->
    <script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>

   
    <script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>

    <!-- Isotope  -->
    <script src="assets/vendors/isotope/isotope.pkgd.js"></script>
    
  
    <!-- JohnDoe js -->
    <script src="assets/js/johndoe.js"></script>

    <script>
      function fade(element, animation) {
        var fadeElement = $(element);

        // Create an Intersection Observer instance
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    fadeElement.css("opacity", 1);
                    fadeElement.removeClass('animate__animated animate__fadeOut' + animation);
                    fadeElement.addClass('animate__animated animate__fadeIn' + animation);
                } else {
                    fadeElement.css("opacity", 0);
                    fadeElement.removeClass('animate__animated animate__fadeIn' + animation);
                    fadeElement.addClass('animate__animated animate__fadeOut' + animation);
                }
            });
        });

        // Observe the fadeElement
        observer.observe(fadeElement[0]);
    }
    $(document).ready(function() {
        fade(".shows", "Right");
        fade(".show-another", "Left");
    });

</script>






</body>
</html>
