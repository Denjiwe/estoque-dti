<?php
    $home = '../../../home.php';
    if (!$_SESSION['dti']) {
?>
            <div class='container'>
                <div class='alert alert-danger mt-5'>Você não tem acesso a essa página!</div>
                <a class='btn btn-light mt-2' href='<?=$home?>'>Voltar para Home</a>
            </div>  
        </body>
    </html>    
<?php
        die();
    }
?>    