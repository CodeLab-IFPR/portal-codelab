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
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <?php $__currentLoopData = $noticias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noticia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4">
                        <img src=<?php echo e($noticia->imagem); ?> class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($noticia->titulo); ?></h5>
                            <p class="card-text"> <?php echo e(Str::limit($noticia->conteudo, 100)); ?></p>
                            <p class="card-text"><small class="text-body-secondary"><?php echo e($noticia->updated_at); ?> </small></p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm">
                                <a href="<?php echo e(route('noticias.edit', $noticia->id)); ?>" class="btn btn-warning btn-sm">Editar</a>
                            </div>
                            <div class="col-sm">
                                <form action="<?php echo e(route('noticias.destroy', $noticia->id)); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </main>
    </section>
</body>

</html><?php /**PATH C:\Users\joaovdms\Documents\IFPR\TCC\projeto\portal-cdt\resources\views/noticias/index.blade.php ENDPATH**/ ?>