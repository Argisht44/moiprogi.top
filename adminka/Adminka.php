<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['username'])) {
    // Если пользователь не авторизован, перенаправляем его на страницу входа
    header('Location: index.html');
    exit();
}

// Код ниже отвечает за отображение содержимого страницы Adminka.php
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-********" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        padding: 10px;
        background-color: #f0f0f0;
        font-size: 14px;
    }
    
    .delete-button {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: #FF0000;
        color: #fff;
        border: none;
        border-radius: 3px;
        padding: 3px 6px;
        cursor: pointer;
        font-size: 12px;
    }
    button, input[type="submit"] {
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 3px;
        padding: 8px 16px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    button:hover, input[type="submit"]:hover {
        background-color: #0056b3;
    }

    button:active, input[type="submit"]:active {
        transform: scale(0.95);
    }
    form {
        background-color: #fff;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);
        position: relative; 
    }
    form input[type="text"],
    form input[type="file"],
    form textarea {
        width: 100%;
        padding: 5px;
        margin-bottom: 5px;
        border-radius: 3px;
        border: 1px solid #ccc;
    }
    form input[type="submit"] {
        padding: 5px 10px;
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }
    .edit-button {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 3px;
        padding: 3px 6px;
        cursor: pointer;
        font-size: 12px;
        right: 60px;
        margin-right: 10px;
    }
    .film {
        position: relative;
        display: flex;
        background-color: #fff;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);
    }
    .film img {
        width: 100px;
        height: auto;
        margin-right: 10px;
    }
    .film-info {
        display: flex;
        flex-direction: column;
    }
    .modal-lg {
        max-width: 80%;
    }
    #searchResults {
        display: none;
        position: absolute;
        width: calc(100% - 20px);
        background-color: #f8f9fa;
        border: 1px solid #ccc;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        z-index: 1;
        margin-top: 3px;
        max-height: 100px;
        overflow-y: auto;
        right: 10px;
    }
    #searchResults ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    #searchResults li {
        padding: 4px;
        border-bottom: 1px solid #ccc;
        cursor: pointer;
    }
    #searchResults li:hover {
        background-color: #f0f0f0;
    }

    @media screen and (max-width: 600px) {
        body {
            font-size: 12px;
        }
        form {
            padding: 5px;
        }
        .film {
            flex-direction: column;
            padding-top: 30px;
        }
        .edit-button {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
            right: 60px;
            margin-right: 10px;
        }
        .delete-button {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }

        .film img {
            margin-top: -20px;
            width: 100%;
            margin-bottom: 30px;
        }
        
    }
</style>
</head>
<body>

<!-- Кнопка выхода -->
<div class="logout-container">
    <form action="logout.php" method="post">
        <button type="submit" class="logout-btn" title="Выход">
            <i class="fas fa-sign-out-alt"></i>
        </button>
    </form>
</div>

<!-- Форма для добавления фильма -->
<form id="filmForm">
    <label for="title">Название:</label>
    <input type="text" id="title" name="title"><br>
    <!-- Контейнер для результатов поиска -->
    <div id="searchResults"></div>
    <label for="poster">Постер:</label>
    <input type="file" id="poster" name="poster"><br>
    <label for="description">Описание:</label>
    <textarea id="description" name="description"></textarea><br>
    <label for="youtube_link">Ссылка на Youtube:</label>
    <input type="text" id="youtube_link" name="youtube_link"><br>
    <label for="release_year">Год выпуска:</label>
    <input type="text" id="release_year" name="release_year"><br>
    <input type="submit" value="Добавить фильм">
</form>

<!-- Модальное окно для редактирования фильма -->
<div class="modal" id="editFilmModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование фильма</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editFilmForm">
                    <input type="hidden" id="edit_id" name="id">
                    <label for="edit_title">Название:</label>
                    <input type="text" id="edit_title" name="title"><br>
                    <label for="edit_poster">Постер:</label>
                    <input type="file" id="edit_poster" name="poster"><br>
                    <label for="edit_description">Описание:</label>
                    <textarea id="edit_description" name="description"></textarea><br>
                    <label for="edit_youtube_link">Ссылка на Youtube:</label>
                    <input type="text" id="edit_youtube_link" name="youtube_link"><br>
                    <label for="edit_release_year">Год выпуска:</label>
                    <input type="text" id="edit_release_year" name="release_year"><br>
                    <input type="submit" value="Сохранить изменения">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Контейнер для отображения списка фильмов -->
<div id="films">
    <!-- Здесь будет динамически загружаться список фильмов -->
</div>

<script>
    $(document).ready(function() {
        // Функция для загрузки фильмов
        function loadFilms() {
            $.ajax({
                url: 'getFilms.php',
                type: 'GET',
                success: function (data) {
                    $('#films').html(data);
                }
            });
        }

        // Функция для поиска фильмов
        function findFilms(query) {
            $.ajax({
                url: 'findFilm.php',
                type: 'POST',
                data: { title: query },
                success: function(data) {
                    $('#searchResults').empty();
                    if (data.length > 0) {
                        var resultsList = data.map(function(film) {
                            return '<li data-id="' + film.id + '">' + film.title + '</li>';
                        }).join('');
                        $('#searchResults').append('<ul>' + resultsList + '</ul>');
                        $('#searchResults').show();
                    } else {
                        $('#searchResults').hide();
                    }
                }
            });
        }

        // Обработчик события при вводе в поле названия фильма
        $('#title').on('input', function() {
            var query = $(this).val();
            if (query.length > 0) {
                findFilms(query);
            } else {
                $('#searchResults').empty();
                $('#searchResults').hide();
            }
        });

        // Обработчик события для отправки формы добавления фильма
        $('#filmForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: 'addFilm.php',
                type: 'POST',
                data: formData,
                success: function (data) {
                    showSuccessModal('Фильм успешно добавлен');
                    loadFilms();
                    $('#title').val('');
                    $('#poster').val('');
                    $('#description').val('');
                    $('#youtube_link').val('');
                    $('#release_year').val('');
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        // Обработчик события для кнопки "Редактировать"
        $(document).on('click', '.edit-button', function() {
            var id = $(this).data('id');
            openEditModal(id);
        });

// Обработчик события для отправки формы редактирования фильма
$('#editFilmForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: 'editFilm.php',
                type: 'POST',
                data: formData,
                success: function (data) {
                    showSuccessModal('Фильм успешно отредактирован');
                    loadFilms();
                    // Закрываем модальное окно после успешного редактирования
                    $('#editFilmModal').modal('hide');
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        // Обработчик события для конвертации изображения в формат JPEG
        $('#filmForm').on('change', '#poster', function() {
            var fileInput = this;
            var file = fileInput.files[0];

            if (file && file.type.match('image.*')) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var img = new Image();
                    img.onload = function() {
                        var canvas = document.createElement('canvas');
                        canvas.width = img.width;
                        canvas.height = img.height;
                        var ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0);
                        var dataURL = canvas.toDataURL('image/jpeg');
                        var convertedImage = dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
                        var convertedFile = new File([convertedImage], 'poster.jpg', { type: 'image/jpeg' });
                        fileInput.files[0] = convertedFile;
                    };
                    img.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        });

        // Загрузка фильмов при загрузке DOM
        loadFilms();

        // Функция для открытия модального окна для редактирования фильма по ID
        function openEditModal(id) {
            $.ajax({
                url: 'getFilm.php',
                type: 'GET',
                data: { id: id },
                success: function (data) {
                    var film = JSON.parse(data);
                    // Очищаем и заполняем форму для редактирования
                    $('#edit_id').val(film.id);
                    $('#edit_title').val(film.title);
                    $('#edit_description').val(film.description);
                    $('#edit_youtube_link').val(film.youtube_link);
                    $('#edit_release_year').val(film.release_year);
                    // Показываем модальное окно для редактирования
                    $('#editFilmModal').modal('show');
                }
            });
        }

        // Функция для отображения модального окна с сообщением об успешной операции
        function showSuccessModal(message) {
            var successModal = $('<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">' +
                                  '<div class="modal-dialog" role="document">' +
                                  '<div class="modal-content">' +
                                  '<div class="modal-header">' +
                                  '<h5 class="modal-title" id="successModalLabel">Успешно</h5>' +
                                  '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                                  '<span aria-hidden="true">&times;</span>' +
                                  '</button>' +
                                  '</div>' +
                                  '<div class="modal-body">' + message + '</div>' +
                                  '</div>' +
                                  '</div>' +
                                  '</div>');
            $('body').append(successModal);
            $('#successModal').modal('show');
            $('#successModal').on('hidden.bs.modal', function() {
                $(this).remove();
            });
        }

        $(document).on('click', '.delete-button', function() {
            var id = $(this).data('id');
            var confirmDelete = confirm('Вы уверены, что хотите удалить этот фильм?');
            if (confirmDelete) {
                $.ajax({
                    url: 'deleteFilm.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(data) {
                        showSuccessModal('Фильм успешно удален');
                        loadFilms();
                    }
                });
            }
        });
    });
</script>

</body>
</html>