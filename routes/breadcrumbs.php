<?php
// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('dashboard',  function (BreadcrumbTrail  $trail) {
   $trail->push('Inicio', route('dashboard'));
});

Breadcrumbs::for('logs',  function (BreadcrumbTrail  $trail) {
   $trail->parent('dashboard');
   $trail->push('Logs SIADI', route('log-index'));
});

Breadcrumbs::for('users', function (BreadcrumbTrail  $trail){
   $trail->parent('dashboard');
   $trail->push('Usuarios SIADI', route('user-index'));
});

Breadcrumbs::for('user-detail', function (BreadcrumbTrail $trail, $user) {
   $trail->parent('users');
   $trail->push($user->full_name, route('user-detail', $user->id));
});

Breadcrumbs::for('students', function (BreadcrumbTrail  $trail){
   $trail->parent('dashboard');
   $trail->push('Usuarios plataforma', route('moodle-index'));
});

Breadcrumbs::for('student-mass-creation', function (BreadcrumbTrail $trail){
   $trail->parent('students');
   $trail->push('Creación masiva', route('moodle-mass-creation'));
});

Breadcrumbs::for('students-detail', function (BreadcrumbTrail $trail, $student) {
   $trail->parent('students');
   $trail->push($student->full_name, route('moodle-detail', $student->id));
});

Breadcrumbs::for('students-report', function (BreadcrumbTrail $trail) {
   $trail->parent('students');
   $trail->push("Estadísticas", route('moodle-report'));
});

Breadcrumbs::for('role', function (BreadcrumbTrail  $trail){
   $trail->parent('dashboard');
   $trail->push('Roles SIADI', route('role-index'));
});

Breadcrumbs::for('permission', function (BreadcrumbTrail  $trail){
   $trail->parent('dashboard');
   $trail->push('Permisos', route('permission-index'));
});

Breadcrumbs::for('category', function (BreadcrumbTrail  $trail){
   $trail->parent('dashboard');
   $trail->push('Categorias', route('category-index'));
});

Breadcrumbs::for('program', function (BreadcrumbTrail  $trail){
   $trail->parent('dashboard');
   $trail->push('Programas', route('program-index'));
});

Breadcrumbs::for('program-detail', function (BreadcrumbTrail $trail, $program) {
   $trail->parent('program');
   $trail->push($program->name, route('program-detail', $program->id));
});

Breadcrumbs::for('course', function (BreadcrumbTrail  $trail){
   $trail->parent('dashboard');
   $trail->push('Asignaturas', route('course-index'));
});

Breadcrumbs::for('course-not-dashboard', function (BreadcrumbTrail  $trail){
   $trail->push('Asignaturas', route('course-index'));
});

Breadcrumbs::for('course-detail', function (BreadcrumbTrail $trail, $course) {
   $trail->parent('program');
   $trail->push($course->program->name, route('program-detail', $course->program_id));
   $trail->parent('course-not-dashboard');
   $trail->push($course->name, route('course-detail', $course->id));
});

Breadcrumbs::for('course-report', function (BreadcrumbTrail $trail) {
   $trail->parent('course');
   $trail->push("Estadísticas", route('course-report'));
});

Breadcrumbs::for('group', function (BreadcrumbTrail  $trail){
   $trail->parent('dashboard');
   $trail->push('Grupos', route('group-index'));
});

Breadcrumbs::for('group-not-dashboard', function (BreadcrumbTrail  $trail){
   $trail->push('Grupo', route('group-index'));
});

Breadcrumbs::for('group-detail', function (BreadcrumbTrail $trail, $group) {
   $trail->parent('program');
   $trail->push($group->course->program->name, route('program-detail', $group->course->program_id));
   $trail->parent('course-not-dashboard');
   $trail->push($group->course->name, route('course-detail', $group->course->id));
   $trail->push('Grupo: '. $group->name, route('group-detail', $group->id));
});

Breadcrumbs::for('role_moodle', function (BreadcrumbTrail  $trail){
   $trail->parent('dashboard');
   $trail->push('Roles matrículas', route('role-moodle-index'));
});

Breadcrumbs::for('state_enrollment', function (BreadcrumbTrail  $trail){
   $trail->parent('dashboard');
   $trail->push('Estados de matrículas', route('state-enrollment-index'));
});


Breadcrumbs::for('enrollment', function (BreadcrumbTrail  $trail){
   $trail->parent('dashboard');
   $trail->push('Matrículas', route('enrollment-index'));
});

Breadcrumbs::for('enrollment-mass-creation', function (BreadcrumbTrail $trail){
   $trail->parent('enrollment');
   $trail->push('Creación masiva', route('enrollment-mass-creation'));
});

Breadcrumbs::for('unenrollment-mass-update', function (BreadcrumbTrail $trail){
    $trail->parent('enrollment');
    $trail->push('Desmaticulación masiva', route('unenrollment-mass-update'));
});

Breadcrumbs::for('susenrollment-mass-update', function (BreadcrumbTrail $trail){
   $trail->parent('enrollment');
   $trail->push('Suspensión masiva', route('susenrollment-mass-update'));
});

Breadcrumbs::for('enrollment-report', function (BreadcrumbTrail $trail) {
   $trail->parent('enrollment');
   $trail->push("Estadísticas", route('enrollment-report'));
});

Breadcrumbs::for('search', function (BreadcrumbTrail  $trail){
   $trail->parent('dashboard');
   $trail->push('Búsqueda', route('search-index'));
});

Breadcrumbs::for('reports-never', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Reports Never', route('reports-never.index'));
});

Breadcrumbs::for('dashboard.reports', function ($trail) {
    $trail->push('Reports', route('dashboard.reports'));
});
