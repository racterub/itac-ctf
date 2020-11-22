<?php




$connection = new PDO('mysql:host=db;dbname=blog;charset=utf8mb4', 'itac', '174c_v3ry_L0n9_p4ZZW0rd_L0L');


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $sql = "SELECT title, content FROM news WHERE id=".$_GET['id'].";";
    $query = $connection->query($sql);
    if ($query) {
        $result = $query->fetchObject();
        if ($result) {
            $title = $result->title;
            $content = $result->content;
        }
    }
} else {
    $sql = "SELECT id, title FROM news";
    $list = $connection->query($sql)->fetchAll();
    //var_dump($list);
    
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ITAC | CatHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tocas-ui/2.3.3/tocas.css">
    <style>
        body {
            background-color: #373A40
        }
    
        .segment {
            background-color: #99A8B2
        }
    </style>
        
</head>
<body>
    <div class="ts very narrow container">
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <?php if ($list) : ?>
            <div class="ts very padded secondary segment">
                <div class="ts relaxed divided massive bulleted list">
                <?php foreach($list as $data) {
                echo "<a class='item' href='?id=".$data['id']."'>".$data['title']."</a>";
                } ?>
                </div>
            </div>
        <?php else : ?>

        <div class="ts center aligned secondary segment">
            <h1 class="ts header"><?php echo $title;?></h1>
            <div class="ts divider"></div>
            <p> <?php echo $content;?> </p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
