<?php
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['path'])) {
            function list_files_and_folders($path, $relative_path) {
                $items = scandir($path);
                echo "<ul>";
                foreach ($items as $item) {
                    if ($item === '.' || $item === '..') continue;

                    $full_item_path = $path . '/' . $item;
                    $relative_item_path = $relative_path . '/' . $item;

                    if (is_dir($full_item_path)) {
                        echo "<li class='item folder' data-type='folder' data-path='$relative_item_path'>
                        <div class='icon'><img src='../src/images/icons/folder.png'></div>
                        <span class='item__title'>$item</span> 
                        </li>";
                    } else {
                        echo "<li class='item folder' data-type='file' data-path='$relative_item_path'>
                        <div class='icon'><img src='../src/images/icons/pdf.png'></div>
                        <span class='item__title'>$item</span> 
                        </li>";
                        // echo "<li class='item folder' data-type='file' data-path='$relative_item_path'>
                        // <div class='icon'><img src='../src/images/icons/pdf.png'></div>
                        // <a href='?file=$relative_item_path' class='item__title'>$item</a> 
                        // </li>";
                    }
                }
                echo "</ul>";
                // var_dump( $items); //implementar futuramente um metodo que retorne apenas uma array JSON para que o JS faça a
                //renderização dos itens, e não o PHP.
                //pois essa forma de comunicação/renderização causa conflitos de caminhos relativos dos arquivos 
                //por exemplo ao apontar a src de uma imagem, pois a div será renderizada em um diretório superior
                //então o caminho relativo da imagem não parte deste arquivo php, e sim de onde será renderizado.
            }

            $base_path = '../../uploads/';
            $relative_path = trim($_GET['path'], '/');
            $full_path = $base_path . $relative_path;

            if (is_dir($full_path)) {
                list_files_and_folders($full_path, $relative_path);
            } else {
                echo "Invalid path";
            }
        } else {
            // Display the root directory by default
            $_GET['path'] = '';
            include(__FILE__);
        }
        ?>