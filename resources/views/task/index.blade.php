<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Todo List</title>
  <style>
    *,*::before,*::after{
      box-sizing: border-box;
    }

    html{
      box-sizing: inherit;
      font-family: system-ui, sans-serif;
    }

    h1{
      text-align: center;
      color: #09f;
      font-weight: bold
    }

    form {
      text-align: center;
      margin-block:20px;
      display: flex;
      gap: 10px;
      justify-content: center;

      & > input[type="text"]{
        width: 300px;
        padding: 10px;
        font-size: 16px;
        border: none;
        border-bottom: 1px solid #d2d2d2;
        outline: none;
        background: transparent;
      }

      & > input[type="submit"]{
        width: 50px;
        rounded: 100%;
        padding: 10px;
        font-size: 16px;
        border: none;
        background-color: #09f;
        color: white;
        cursor: pointer;
      }
    }

    main{
      width: 100%;
      height: 500px;
      display: flex;
      gap: 10px;
      margin-bottom: 100px;

      & > div{
        flex-grow: 1;
        background-color: var(--color-bg);
        display: flex;
        flex-direction: column;
        color:white;
        text-align: center;        

        & > ul{
          text-align: left;
          margin: 0%;
          padding: 0%;
          list-style: none;
          flex-grow: 1;
          background-color: #ebebeb;
          color:black;

          & > li {
            padding: 5px 20px;
            cursor: grab;

            &:hover {
              background-color: rgb(76, 76, 76);
              color: white;
            }
          }
        }
      }
    }

    .logout{
      position: absolute;
      width: 50px;
      height: 50px;
      top: 20px;
      right: 20px;
      background-color: rgb(237, 58, 58);
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 100%;
      transition: background-color .5s ease;

      &:hover{
        background-color: rgb(213, 104, 104);
      }
    }


  </style>
</head>
<body>

  <button class="logout">
    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M15 12h-12l3 -3" /><path d="M6 15l-3 -3" /></svg>
  </button>

  <h1>TO-DO</h1>

  <form action="" method="POST">
    <input type="text" name="task" placeholder="Alguna nueva tarea?">
    <input type="submit" value="Add">
  </form>

  <main>
    <div class="toDo" style="--color-bg: rgb(186, 62, 74);">
      <h2>To Do</h2>    
      <ul class="tasks">
      </ul>
    </div>
    <div class="onProgress" style="--color-bg: rgb(62, 99, 186);">
      <h2>En proceso</h2>
      <ul></ul>
    </div>
    <div class="finished" style="--color-bg: rgb(54, 162, 90);">
      <h2>Finalizadas</h2>
      <ul></ul>
    </div>
  </main>

  <script>
    const $tasks = document.querySelector('.tasks');

    document.addEventListener('DOMContentLoaded', (event) => {
      const token = localStorage.getItem('token');

      fetch('http://localhost/laravel/todolist-one/public/api/auth/tasks',{
        headers:{
          Authorization: `Bearer ${token}`
        }
      })
        .then(res => res.json())
        .then(data => {
          data.forEach(d => {
            const $li = document.createElement('li');
            $li.setAttribute('draggable', 'true');
            $li.textContent = d.task;
            $li.addEventListener('dragstart', handleDragStart);

            $tasks.appendChild($li);
          })})
        .catch(err => {
          console.log(err);
        });
    });

    const token = localStorage.getItem('token');
    const $form = document.querySelector('form');
    $form.addEventListener('submit', e => {
      e.preventDefault();

      const task = $form.task.value;      

      fetch('http://localhost/laravel/todolist-one/public/api/auth/create',{
        method: 'POST',
        headers:{
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          task
        })
      }).then(res => res.json())
        .then(data => {          
          $form.task.value = '';

          const $li = document.createElement('li');
          $li.setAttribute('draggable', 'true');
          $li.textContent = data.task;
          $li.addEventListener('dragstart', handleDragStart);

          $tasks.appendChild($li);
        })
        .catch(err => {
          console.log(err);
        });
    });


    let currentTarget = null;

    function handleDragStart(e) {
      e.dataTransfer.setData('text/plain', e.target.textContent);
      // console.log(e);
      currentTarget = e.target;
    }


    const $onProgress = document.querySelector('.onProgress ul');
    const $finished = document.querySelector('.finished ul');

    $onProgress.addEventListener('dragover', handleDragOver);
    $onProgress.addEventListener('drop', handleDrop);
    $onProgress.addEventListener('dragleave', handleDragLeave);

    $finished.addEventListener('dragover', handleDragOver);
    $finished.addEventListener('drop', handleDrop);
    $finished.addEventListener('dragleave', handleDragLeave);

    $tasks.addEventListener('dragover', handleDragOver);
    $tasks.addEventListener('drop', handleDrop);
    $tasks.addEventListener('dragleave', handleDragLeave);

    function handleDragOver(e) {
      e.preventDefault();
      // console.log(e);      
    }

    function handleDrop(e) {
      e.preventDefault();
      const $droppedElement = e.target.closest('ul');
      $droppedElement.appendChild(currentTarget);
      // $tasks.removeChild(currentTarget);
    }

    function handleDragLeave(e) {
      e.preventDefault();
      // console.log(e);
    }


    $logout = document.querySelector('.logout');
    $logout.addEventListener('click', e => {
      e.preventDefault();

      fetch('http://localhost/laravel/todolist-one/public/api/auth/logout',{
        method: 'POST',
        headers:{
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        }
      }).then(res => res.json())
        .then(data => {
          console.log(data);
          localStorage.removeItem('token');
          window.location.href = `http://localhost/laravel/todolist-one/public/`;
        })
        .catch(err => {
          console.log(err);
        });
    });


  </script>
</body>
</html>