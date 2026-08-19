# Sistema de Cadastro de Pratos

Neste projeto desenvolvemos um sistema simples para um restaurante, com o objetivo de organizar o cadastro de usuários e pratos.

Utilizamos PHP, MySQL, HTML e CSS**, executando o projeto localmente pelo XAMPP. Criamos um banco de dados com duas tabelas relacionadas: uma para os usuários e outra para os pratos.

Primeiramente, desenvolvemos o cadastro de usuários, onde é possível informar o nome e o e-mail. Depois, criamos o cadastro de pratos, permitindo informar o nome, descrição, preço e categoria.

Também fizemos a listagem dos pratos cadastrados, mostrando o usuário responsável por cada prato. Dessa forma, conseguimos relacionar os registros da tabela de pratos com os usuários cadastrados no sistema.

Além do cadastro e da visualização, adicionamos as funções de **editar e excluir pratos** e também a possibilidade de visualizar os pratos cadastrados por um determinado usuário.

Durante o desenvolvimento, utilizamos **Prepared Statements** nas operações que recebem dados dos formulários, buscando deixar o sistema mais seguro contra SQL Injection. Também adicionamos validações para evitar o cadastro com campos obrigatórios vazios.

O projeto foi desenvolvido em dupla e versionado utilizando **Git e GitHub**, com commits realizados durante o desenvolvimento para registrar a evolução do sistema.

Com isso, conseguimos criar um sistema funcional que demonstra a comunicação entre **formulário, PHP e banco de dados**, além do relacionamento entre usuários e pratos.
