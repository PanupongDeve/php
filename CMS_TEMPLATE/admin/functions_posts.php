<?php 

function insert_post(){
	global $connection;

	if(isset($_POST['create_post'])){

		$post_title = mysqli_real_escape_string($connection,$_POST['post_title']);
		$post_author =  mysqli_real_escape_string($connection,$_POST['post_author']);
		$post_category_id =  mysqli_real_escape_string($connection,$_POST['post_category']);
		$post_status =  mysqli_real_escape_string($connection,$_POST['post_status']);

		$post_image =  mysqli_real_escape_string($connection,$_FILES['post_image']['name']);
		$post_image_temp =  mysqli_real_escape_string($connection,$_FILES['post_image']['tmp_name']);

		$post_tags = mysqli_real_escape_string($connection,$_POST['post_tags']);
		$post_content =  mysqli_real_escape_string($connection,$_POST['post_content']);
		$post_date = date('d-m-y');
		$post_comment_count = 0;

		move_uploaded_file($post_image_temp, "../images/$post_image");
		
		$query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
		$query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', {$post_comment_count}, '{$post_status}') ";
	
		 $create_post = mysqli_query($connection, $query);

            if(!$create_post){
                // die('QUERY FAILED'. mysql_error($connection));
                echo "Error: " . $query . "<br>" . $connection->error;
            }
	}



}

function ViewAllPosts(){
	global $connection;

	    $query = "SELECT * FROM posts";
        $select_posts = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($select_posts)){
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];

            echo "<tr>";
            echo "<td>$post_id</td>";
            echo "<td>$post_author</td>";
            echo "<td>$post_title</td>";

            	$query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
            	$select_categories_id = mysqli_query($connection,$query);

            	while($row = mysqli_fetch_assoc($select_categories_id)){
            		$cat_id = $row['cat_id'];
            		$cat_title = $row['cat_title'];

            		 echo "<td>{$cat_title}</td>";
            	}



    
            echo "<td>$post_status</td>";
            echo '<td><img width="100" src="../images/'.$post_image.'"></td>';
            echo "<td>$post_tags</td>";
            echo "<td>$post_comment_count</td>";
            echo "<td>$post_date</td>";
            echo "<td><a href='./posts.php?source=edit_post&edit={$post_id}'>Edit</a></td>";
            echo "<td><a href='./posts.php?delete={$post_id}'>Delete</a></td>";         
            echo "</tr>";
        }

}

function deletePost(){
	global $connection;

	if(isset($_GET['delete'])){

	  $the_post_id = $_GET['delete'];

	  $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
	  $delete_query = mysqli_query($connection, $query);
	  header("location: posts.php");

	}
}





?>