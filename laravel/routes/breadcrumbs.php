<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Home > Notes
Breadcrumbs::for('notes.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Notes', route('notes.index'));
});

// Home > Notes > [Note Title]
Breadcrumbs::for('notes.show', function (BreadcrumbTrail $trail, $note) {
    $trail->parent('notes.index');
    $trail->push($note->title, route('notes.show', $note->id));
});

// Home > My Notes
Breadcrumbs::for('notes.mynotes', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('My Notes', route('notes.mynotes'));
});

// Home > Notes > Create
Breadcrumbs::for('notes.create', function (BreadcrumbTrail $trail) {
    $trail->parent('notes.index');
    $trail->push('Create Note', route('notes.create'));
});

// Home > Notes > [Note Title] > Edit
Breadcrumbs::for('notes.edit', function (BreadcrumbTrail $trail, $note) {
    $trail->parent('notes.show', $note);
    $trail->push('Edit Note', route('notes.edit', $note->id));
});
