<?php

require('../config.php');
// recebe o método de envio
$method = strtolower($_SERVER['REQUEST_METHOD']);
// verifica se o o método de envio é do tipo put
if ($method === 'delete') {
    // armazena o conteúdo da url na variável $input
    parse_str(file_get_contents('php://input'), $input);
    // se o id não for nulo é recebe o valor do id (url)
    $id = (!empty($input['id'])) ? $input['id'] : null;
    # Expressão que realiza a mesma tarefa da expressão acima, porém funciona apenas para versões do php 7.4 em diante
    # $id = $input['id'] ?? null;
    // filtra a variável
    $id = filter_var($id);
    // se as variáveis não forem nulas
    if ($id) {
        /** @var object $pdo */
        $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $pdo->prepare("DELETE FROM notes WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            // retorno o resultado
            $array['result'] = [
                'retorno' => 'OK'
            ];
        } else {
            $array['error'] = 'ID inexistente';
        }
    } else {
        $array['error'] = [
            'error' => 'ID não envido'
        ];
    }
} else {
    $array['error'] = 'Método não permitido (Apenas DELETE)';
}
require('../return.php');