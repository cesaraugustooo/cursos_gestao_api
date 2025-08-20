# cursos_gestao_api
# 🎓 API de Gestão de Cursos Online (Treinamento)

Este projeto é uma **API REST desenvolvida em Laravel** para gerenciamento de cursos online.  

- Autenticação com diferentes perfis de usuários (`admin`, `instructor`, `student`);
- CRUDs completos de cursos, aulas, matrículas e avaliações;
- Relatórios avançados baseados em tempo;
- Upload e listagem de materiais de aula.

---

## 🚀 Tecnologias Utilizadas
- PHP 8.x
- Laravel 10.x
- MySQL
- Laravel Sanctum (autenticação via token)
- Composer
- Postman (para testes dos endpoints)

---

## 📌 Estrutura do Banco de Dados (principais tabelas)

- **users** → (id, name, email, password, role)  
- **cursos** → (id, titulo, descricao, preco, status, user_id)  
- **aulas** → (id, curso_id, titulo, conteudo, duracao)  
- **matriculas** → (id, user_id, curso_id, status, created_at)  
- **avaliacoes** → (id, user_id, curso_id, nota, comentario, created_at)  
- **materiais_aula** *(extra adicionado)* → (id, aula_id, file_path)  

---

## 🔑 Autenticação

Autenticação via **Laravel Sanctum**.

- `POST /api/register` → cadastro (default: student)  
- `POST /api/login` → login e geração de token  
- `POST /api/logout` → logout  

📌 Regras de negócio:
- Apenas **admin** pode cadastrar instrutores.  
- Apenas **instrutores** podem criar cursos.  
- Alunos não podem se matricular em cursos com status `rascunho`.  
- Aluno só avalia curso se matrícula estiver `concluída`.  

---

## 📚 Endpoints Principais

### 🔹 Cursos
- `GET /cursos` → lista cursos publicados (com paginação e filtro por instrutor).  
- `POST /cursos` → cria curso (instrutor).  
- `PUT /cursos/{id}` → atualiza curso (instrutor dono ou admin).  
- `DELETE /cursos/{id}` → exclui curso.  

### 🔹 Aulas
- `POST /cursos/{id}/aulas` → cria aula.  
- `GET /cursos/{id}/aulas` → lista aulas do curso.  
- `DELETE /aulas/{id}` → remove aula.  

### 🔹 Matrículas
- `POST /cursos/{id}/matricular` → aluno se matricula.  
- `GET /meus-cursos` → lista cursos do aluno autenticado.  
- `PUT /matriculas/{id}/status` → admin altera status.  

### 🔹 Avaliações
- `POST /cursos/{id}/avaliar` → aluno avalia curso concluído.  
- `GET /cursos/{id}/avaliacoes` → lista avaliações de um curso.  

---

## 📊 Relatórios
- `GET /relatorios/matriculas-mensais` → matrículas por mês no último ano.  
- `GET /relatorios/faturamento-mensal` → faturamento mensal (apenas admin).  
- `GET /relatorios/engajamento-alunos` → percentual de alunos que concluíram cursos por mês.  
- `GET /relatorios/top-instrutores?mes=YYYY-MM` → top 3 instrutores por faturamento.  

---


### Materiais de Aulas
Endpoints:

POST /aulas/{aula}/material → upload de material (somente instrutor dono).

GET /aulas/{aula}/materiais → lista materiais de uma aula (qualquer usuário autenticado).
