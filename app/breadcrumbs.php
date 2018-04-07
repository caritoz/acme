<?php
Breadcrumbs::register('admin', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin.index'));
});

Breadcrumbs::register('picture', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Imagenes', route('admin.pictures.index'));
});
Breadcrumbs::register('picture-child', function($breadcrumbs) {
    $breadcrumbs->parent('picture');
    $breadcrumbs->push('Imagen', route('admin.pictures.index'));
});
Breadcrumbs::register('albums', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Albums', route('admin.albums.index'));
});
Breadcrumbs::register('albums-child', function($breadcrumbs) {
    $breadcrumbs->parent('albums');
    $breadcrumbs->push('Album', route('admin.albums.index'));
});

Breadcrumbs::register('performedworks', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Proyectos', route('admin.performedworks.index'));
});

Breadcrumbs::register('performedworks-child', function($breadcrumbs) {
    $breadcrumbs->parent('performedworks');
    $breadcrumbs->push('Proyecto', route('admin.performedworks.index'));
});

Breadcrumbs::register('clients', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Clientes', route('admin.clients.index'));
});
