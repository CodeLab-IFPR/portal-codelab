<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Noticias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
</head>

<body>
    <section>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-warning">
                <div class="container-fluid">
                    <a class="navbar-brand h1" href=<?php echo e(route('noticias.index')); ?>>CRUD Noticas</a>
                    <div class="justify-end">
                        <div class="col ">
                            <a class="btn btn-sm btn-success" href=<?php echo e(route('noticias.create')); ?>>Add Noticia</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
    </section>
    <section>
        <main>
            <div class="container h-100 mt-5">
                <div class="row h-100 justify-content-center align-items-center">
                    <div class="col-10 col-md-8 col-lg-6">
                        <h3>Atualizar Noticia</h3>
                        <form action="<?php echo e(route('noticias.update', $noticia->id)); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="form-group">
                                <label for="Autor">Autor</label>
                                <input type="text" class="form-control" name="autor" id="autor" value="<?php echo e($noticia->autor); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="Titulo">Titulo</label>
                                <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo e($noticia->titulo); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="Conteudo">Conteudo</label>
                                <textarea class="form-control" name="conteudo" id="conteudo" value="<?php echo e($noticia->conteudo); ?>" rows="6" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Imagem">Imagem</label>
                                <input type="file" class="form-control" name="imagem" id="imagem" value="<?php echo e($noticia->imagem); ?>" required>
                            </div>
                            <br>
                            <button class="btn mt-3 btn-primary" type="submit">Atualizar noticia</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </section>
</body>

</html><?php /**PATH C:\Users\joaovdms\Documents\IFPR\TCC\projeto\portal-cdt\resources\views/noticias/edit.blade.php ENDPATH**/ ?>