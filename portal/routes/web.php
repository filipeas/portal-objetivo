<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AuthController@auth')->name('login');
Route::post('login/do', 'AuthController@login')->name('login.do');
Route::get('logout/do', 'AuthController@logout')->name('logout.do');

// ROTAS DE CONFIGURAÇÃO
Route::get('image-crop', 'CursoController@getImageCrop');
Route::post('image-crop', 'CursoController@postImageCrop');

Route::group(['prefix' => 'administrativo', 'middleware' => ['auth', 'is_admin']], function () {
    // ROTA INICIAL
    Route::get('inicio', 'AdministradorController@home')->name('admin.home');

    // ROTAS DE PERFIL
    Route::get('configuracao/todos', 'AdministradorController@index')->name('admin.config.index');
    Route::get('configuracao/cadastrar/administrador', 'AdministradorController@create')->name('admin.config.create');
    Route::post('configuracao/cadastrar/administrador/do', 'AdministradorController@store')->name('admin.config.store');
    Route::get('configuracao/editar/administrador/{administrador}', 'AdministradorController@edit')->name('admin.config.edit');
    Route::put('configuracao/editar/administrador/{administrador}/do', 'AdministradorController@update')->name('admin.config.update');
    Route::delete('configuracao/excluir/administrador/{administrador}/do', 'AdministradorController@destroy')->name('admin.config.destroy');

    // ROTAS DO CURSO
    Route::get('curso/todos', 'CursoController@index')->name('admin.curso.index');
    Route::get('/curso/cadastrar', 'CursoController@create')->name('admin.curso.create');
    Route::post('/curso/cadastrar/do', 'CursoController@store')->name('admin.curso.store');
    Route::get('/curso/{slug_curso}/visualizar', 'CursoController@show')->name('admin.curso.show');
    Route::get('/curso/{slug_curso}/editar', 'CursoController@edit')->name('admin.curso.edit');
    Route::put('/curso/{slug_curso}/editar/do', 'CursoController@update')->name('admin.curso.update');
    Route::delete('/curso/{slug_curso}/excluir/do', 'CursoController@destroy')->name('admin.curso.destroy');

    // ROTAS DO MATERIAL
    Route::get('/material/curso/{slug_curso}/todos', 'MaterialController@index')->name('admin.material.index');
    Route::get('/material/curso/{slug_curso}/cadastrar', 'MaterialController@create')->name('admin.material.create');
    Route::post('/material/curso/cadastrar/do', 'MaterialController@store')->name('admin.material.store');
    Route::get('/material/{material}/visualizar', 'MaterialController@show')->name('admin.material.show');
    Route::get('/material/{material}/editar', 'MaterialController@edit')->name('admin.material.edit');
    Route::put('/material/{material}/editar/do', 'MaterialController@update')->name('admin.material.update');
    Route::get('/material/{material}/excluir/pdf/do', 'MaterialController@destroyPDF')->name('admin.material.destroy.pdf');
    Route::get('/material/{material}/excluir/doc/do', 'MaterialController@destroyDOC')->name('admin.material.destroy.doc');
    Route::delete('/material/{material}/excluir/do', 'MaterialController@destroy')->name('admin.material.destroy');

    // ROTAS DO ALUNO
    Route::get('/aluno/todos', 'StudentController@index')->name('admin.student.index');
    Route::get('/aluno/cadastrar', 'StudentController@create')->name('admin.student.create');
    Route::post('/aluno/cadastrar/do', 'StudentController@store')->name('admin.student.store');
    Route::get('/aluno/{student}/visualizar', 'StudentController@show')->name('admin.student.show');
    Route::get('/aluno/{student}/editar', 'StudentController@edit')->name('admin.student.edit');
    Route::put('/aluno/{student}/editar/do', 'StudentController@update')->name('admin.student.update');
    Route::delete('/aluno/{student}/excluir/do', 'StudentController@destroy')->name('admin.student.destroy');

    // ROTAS DA MATRICULA
    Route::get('/matricula/todos', 'MatriculaController@index')->name('admin.matricula.index');
    Route::get('/matricula/cadastrar/aluno/{student}', 'MatriculaController@create')->name('admin.matricula.create');
    Route::post('/matricula/cadastrar/do', 'MatriculaController@store')->name('admin.matricula.store');
    Route::get('/matricula/{matricula}/visualizar', 'MatriculaController@show')->name('admin.matricula.show');
    Route::delete('/matricula/{matricula}/excluir/do', 'MatriculaController@destroy')->name('admin.matricula.destroy');
});

Route::group(['prefix' => 'aluno', 'middleware' => ['auth', 'is_student']], function () {
    // ROTAS DE PERFIL
    Route::get('inicio', 'StudentController@home')->name('student.home');
    Route::get('/editar/aluno/{aluno}', 'StudentController@edit')->name('student.config.edit');
    Route::get('/editar/senha/aluno/{aluno}', 'StudentController@editPassword')->name('student.config.edit.password');
    Route::put('/editar/aluno/{aluno}/do', 'StudentController@update')->name('student.config.update');
    Route::put('/editar/senha/aluno/{aluno}/do', 'StudentController@updatePassword')->name('student.config.update.password');

    // ROTAS DO CURSO
    Route::get('curso/todos', 'CursoController@indexStudent')->name('student.curso.index');
    Route::get('/curso/{slug_curso}/visualizar', 'CursoController@showStudent')->name('student.curso.show');

    // ROTAS DO MATERIAL
    Route::get('/material/{material}/visualizar', 'MaterialController@showStudent')->name('student.material.show');
});
