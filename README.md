# Projeto Portal Objetivo

## Descrição:
Esse projeto tem como objetivo atender as requisições do desafio: Criar um sistema de cadastro de Cursos e Portal do Aluno.

## Objetivo do projeto:
O objetivo central desse projeto é atender as principais requisições do desafio, de forma que todas fossem implementadas.

* Detalhes da implementação:
Foi projetado um modelo MER baseado nas requisições do desafio. Observe o modelo na imagem abaixo:

<img src="https://github.com/filipeas/protal-objetivo/blob/master/banco-versao-1.png" width="400">

O modelo conta com dois usuários, sendo eles **Administrador** e **Aluno**.
O Administrador gerencia todo o sistema de controle de cursos, podendo realizar:
1) CRUD de Cursos;
2) CRUD de Materiais de um Curso;
3) CRUD de Alunos;
4) CRUD de Matrículas de Alunos aos Cursos;

A lógica por trás do sistema foi projetado conforme a descrição do desafio, com alguns ajustes realizados após análise durante 
a modelagem do banco.

Há apenas uma entidade usuário no sistema, e a forma de os diferenciar é utilizando um atributo de tipo de usuário.

Para o ambiente administrativo foram realizados os seguintes passos:
- O ambiente administrativo possibilita o controle de cursos;
- O ambiente administrativo possibilita o controle de materiais (PDF, DOC ou Vídeo) no formato de material. Esse material é
vinculado a um curso específico. Esse vínculo não foi especificado no desafio, mas foi implementado devido a inconsistencia
em manter o material desvinculado ao curso. Por exemplo, se fosse mantido desvinculado, qualquer aluno poderia acessar qualquer
material de qualquer curso, sem haver nenhum controle;
- O material cadastrado no ambiente administrativo possibilita o cadastro de dois tipos de arquivos diferentes (PDF e DOC) e um link de
vídeo (somente o código do vídeo), sendo que o administrador tem a liberdade de cadastrar pelo menos um desses três dados. O material anexa todos esses dados a um curso. Ou seja, um curso pode ter vários materiais diferentes. 
- O vídeo anexado ao material pode ser das plataformas do Youtube ou Vimeo. Para isso é necessário que o administrador cadastre apenas
o código do vídeo e marque o tipo do vídeo (informando de qual plataforma o vídeo pertence). Assim, o sistema saberá diferenciar e mostrar
o vídeo corretamente para o aluno.
- O ambiente administrativo possibilita o controle de alunos, possibilitando-os matricular a diferentes cursos cadastrados no sistema;
- O ambiente administrativo possibilita a edição do perfil do administrador;

Para o portal do aluno foram realizados os seguintes passos:
- O portal do aluno possibilita que:
  - O aluno visualize todos os cursos que está matriculado;
  - O aluno visualize todos os materiais de cada curso;
  - O aluno edite seu perfil;
  - O aluno edite sua senha;