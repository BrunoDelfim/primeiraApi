<?php

require('../config.php');
// recebe o método de envio
$method = strtolower($_SERVER['REQUEST_METHOD']);
// verifica se o o método de envio é do tipo put
if ($method === 'put') {
    // armazena o conteúdo da url na variável $input
    parse_str(file_get_contents('php://input'), $input);
    // se o id não for nulo é recebe o valor do id (url)
    $id = (!empty($input['id'])) ? $input['id'] : null;
    # Expressão que realiza a mesma tarefa da expressão acima, porém funciona apenas para versões do php 7.4 em diante
    # $id = $input['id'] ?? null;
    $title = $input['title'] ?? null; // se $input['title'] existir o seu valor será atribuído a variável $title, se não existir, $title será null.
    $body = $input['body'] ?? null;
    // filtra a variável
    $id = filter_var($id);
    $body = filter_var($title);
    $title = filter_var($body);
    // se as variáveis não forem nulas
    if ($id && $title && $body) {
        /** @var object $pdo */
        $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $pdo->prepare("UPDATE notes SET title = :title, body = :body WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->bindValue(':title', $title);
            $sql->bindValue(':body', $body);
            $sql->execute();
            // retorno o resultado
            $array['result'] = [
                'id' => $id,
                'title' => $title,
                'body' => $body
            ];
        } else {
            $array['error'] = 'ID inexistente';
        }
    } else {
        $array['error'] = [
            'error' => 'Dados não enviados'
        ];
    }
} else {
    $array['error'] = 'Método não permitido (Apenas PUT)';
}
require('../return.php');