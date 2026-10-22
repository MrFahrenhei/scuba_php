# About

> /data: pasta onde serão armazenados os dados dos usuários

> /view: pasta com as templates

> /resource: pasta com imagens e css

boot.php: responsável por carregar os arquivos

config.php: responsável por setar constantes

index.php: ponto de entrada do sistema

routes.php: responsável define o que será feito caso uma determinada url seja acionada

## Day 1
Today's task will be to create the `controller.php` and `view.php` files – you will be using something similar to MVC. These two new files will do the work that is currently done by `route.php`.

You will create the `do_register()`, `do_login()`, and `do_not_found()` functions in the `controller.php` file. In the `view.php` file, you will create the `render_view($template)` function.

In the `routes.php` file, instead of loading the response template, you will call the function from `controller.php` according to the `GET ?page=value` parameter.

The `controller.php` file will use the function from the `view.php` file to render the response content.

HTTP is a widely used protocol on the internet. It defines rules and standards for communication between distributed systems, such as error codes or how information will be sent.

An important detail is that the returned HTTP code might need to be different in the `do_not_found()` function. To find out which one, I recommend `https://http.cat`.

An interesting way to create routes is by using a `switch/case` statement and, perhaps, a `default` case for when an invalid option is encountered.

Don't forget to update the `boot.php` file and don't be alarmed if an import error appears. Since ScubaPHP doesn't yet use namespaces, the order of the `include` or `require` statements may alter the final result. If an error appears, simply modify the order of things and that should solve the problem!

## Day 2
In today's challenge, you will create the `crud.php` file and the `crud_create($user)` function to save the data submitted by the user in the registration form.

You will not use a database. The `crud_create($user)` function should read the contents of the `/data/users.json` file, add a new element to the array, and update the contents of the `users.json` file.

For the persistence step, you can use the `file_get_contents`, `file_put_contents`, `json_encode`, and `json_decode` functions.

When a `POST` request arrives from the registration form, you should call the function that saves the data and redirect to the URL `/?page=login` using the `header()` function, if there is any information in the `$_POST` array.

When a GET request arrives at the URL
/?page=register, the same URL as the registration form, you should display the form present in the 'register' template.

This responsibility belongs to the controller.php file!