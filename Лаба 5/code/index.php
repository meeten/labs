<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Объявления</title>
</head>
<body>
    <div id="form">
        <form action="save.php" method="post">
            <label for="email">Email</label>
            <input type="email" name="email" required> <br>

            <label for="category">Category</label>
            <select name="category" required>
                <?php
                $categories = array_filter(glob('categories/*'), 'is_dir');
                foreach ($categories as $category) {
                    $name = basename($category);
                    $displayName = ucfirst($name);

                    echo "<option value=\"$name\">$displayName</option>";
                }
                ?>
            </select> <br>

            <label for="title">Title</label>
            <input type="text" name="title" required> <br>

            <label for="description">Description</label>
            <textarea rows="3" name="description" required></textarea> <br>

            <input type="submit" value="Save">
        </form>
    </div>

    <div id="table">
        <table
            <thead>
                <th>Category</th>
                <th>Email</th>
                <th>Title</th>
                <th>Description</th>
            </thead>
            <tbody>
                <?php
                $dirs = array_filter(glob('categories/*'), 'is_dir');

                foreach ($dirs as $dir) {
                    $category = basename($dir);
                    $subdirs = array_filter(glob("$dir/*"), 'is_dir');

                    foreach ($subdirs as $subdir) {
                        $email = basename($subdir);
                        $files = array_diff(scandir($subdir), array('.', '..'));

                        foreach ($files as $file) {
                            $content = file_get_contents("$subdir/$file");
                            $fileName = pathinfo($file, PATHINFO_FILENAME);
                            echo "<tr>";
                            echo "<td>" . $category . "</td>";
                            echo "<td>" . $email . "</td>";
                            echo "<td>" . $fileName . "</td>";
                            echo "<td>" . $content . "</td>";
                            echo "</tr>";
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
