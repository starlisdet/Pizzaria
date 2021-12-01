<?php

class Database
{

  private $db_host = "localhost";   // HOST Banco de Dados
  private $db_user = "root";   // Usuario do Banco de Dados
  private $db_pass = " ";   // Senha do Usuario do Banco de dados
  private $db_name = "Pizzaria";    // Nome do Banco de Dados

  /*
	  * Variáveis extras que são exigidas por outra função, como variável com booleano
	*/
  private $con = false;         // Verifique se a conexão está ativa
  private $result = array();    // Todos os resultados de uma consulta serão armazenados aqui
  private $myQuery = "";        // usado para depuração de processo com retorno de SQL
  private $numResults = "";     // usado para retornar o número de linhas

  // Função para fazer conexão ao banco de dados
  public function connect () {
    if (!$this->con) {
      $this->myconn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);  // mysql_connect () com variáveis definidas no início da classe de banco de dados
      if ($this->myconn->connect_errno > 0) {
        array_push($this->result, $this->myconn->connect_error);
        return false; // Problema ao Selecionar Banco de Dados
      } else {
        $this->con = true;
        return true; // Conexão Realizada com sucesso
      }
    } else {
      return true; // Conexão já realizada
    }
  }

  // Consulta SQL
  public function sql ($sql) {
    $query = $this->myconn->query($sql);
    if ($query) {
      // Se a consulta retornar> = 1 atribua o número de linhas a numResults
      $this->numResults = $query->num_rows;
      // Percorre os resultados da consulta pelo número de linhas retornadas
      for ($i = 0; $i < $this->numResults; $i++) {
        $r = $query->fetch_array();
        $key = array_keys($r);
        for ($x = 0; $x < count($key); $x++) {
          // Limpa as chaves para que apenas alfavalues sejam permitidos
          if (!is_int($key[$x])) {
            if ($query->num_rows >= 1) {
              $this->result[$i][$key[$x]] = $r[$key[$x]];
            } else {
              $this->result = null;
            }
          }
        }
      }
      return true; // Consulta bem sucedida
    } else {
      array_push($this->result, $this->myconn->error);
      return false; // Nenhuma linha foi retornada
    }
  }

  // Função para selecionar no banco de dados
  public function select ($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null) {

    // Verifica se rows é um array, se sim separamos cada valor
    if (is_array($rows)){
      $newRows = null;
      for ($i = 0; $i < count($rows); $i++){

        // if para não adiciona a primeira virgula a nossa string
        if ($newRows == null) {
          $newRows = $rows[$i];
        } else {
          $newRows = $newRows . ', ' . $rows[$i];
        }
      }
      $rows = $newRows;
    }

    // Crie uma consulta a partir das variáveis passadas para a função
    $q = 'SELECT ' . $rows . ' FROM ' . $table;
    if ($join != null) {
      if(is_array($join)) {
        for ($i = 0; $i < count($join); $i++){
          $q .= ' INNER JOIN ' . $join[$i];
        }
      } else {
        $q .= ' INNER JOIN ' . $join;
      }
    }
    if ($where != null) {
      $q .= ' WHERE ' . $where;
    }
    if ($order != null) {
      $q .= ' ORDER BY ' . $order;
    }
    if ($limit != null) {
      $q .= ' LIMIT ' . $limit;
    }

    $this->myQuery = $q; // Passe de volta o SQL
    // Verifique se a tabela existe
    if ($this->tableExists($table)) {
      // A tabela existe, executa a consulta
      $query = $this->myconn->query($q);
      if ($query) {
        // Se a consulta retornar> = 1 atribua o número de linhas a numResults
        $this->numResults = $query->num_rows;
        // Percorre os resultados da consulta pelo número de linhas retornadas
        for ($i = 0; $i < $this->numResults; $i++) {
          $r = $query->fetch_array();
          $key = array_keys($r);
          for ($x = 0; $x < count($key); $x++) {
            // Limpa as chaves para que apenas alfavalues sejam permitidos
            if (!is_int($key[$x])) {
              if ($query->num_rows >= 1) {
                $this->result[$i][$key[$x]] = $r[$key[$x]];
              } else {
                $this->result[$i][$key[$x]] = null;
              }
            }
          }
        }
        return true; // Consulta bem sucedida
      } else {
        array_push($this->result, $this->myconn->error);
        return false; // Nenhuma linha foi retornada
      }
    } else {
      return false; // Tabela não existe
    }
  }

  // Função para inserir no banco de dados
  public function insert ($table, $params = array()) {
    // Verifique se a tabela existe
    if ($this->tableExists($table)) {
      $sql = 'INSERT INTO `' . $table . '` (`' . implode('`, `', array_keys($params)) . '`) VALUES ("' . implode('", "', $params) . '")';
 
      // Faça a consulta para inserir no banco de dados
      if ($ins = $this->myconn->query($sql)) {
        array_push($this->result, $this->myconn->insert_id);
        return true; // Os dados foram inseridos
      } else {
        array_push($this->result, $this->myconn->error);
        return false; // Os dados não foram inseridos
      }
    } else {
      return false; // Tabela não existe
    }
  }

  // Função para excluir tabela ou linha (s) do banco de dados
  public function delete ($table, $where) {
    // Verifique se a tabela existe
    if ($this->tableExists($table) && $where) {
      // Excluindo linhas
      $delete = 'DELETE FROM ' . $table . ' WHERE ' . $where; // Crie uma consulta para excluir linhas

      // Enviar consulta ao banco de dados
      if ($del = $this->myconn->query($delete)) {
        array_push($this->result, $this->myconn->affected_rows);
        $this->myQuery = $delete; // Passe de volta o SQL
        return true; // A consulta foi executada corretamente
      } else {
        array_push($this->result, $this->myconn->error);
        return false; // A consulta não foi executada corretamente
      }
    } else {
      return false; // A tabela não existe
    }
  }

  // Função para atualizar uma linha no banco de dados
  public function update ($table, $params = array(), $where) {

    // Verifique se a tabela existe
    if ($this->tableExists($table)) {
      // Crie uma matriz para conter todas as colunas a serem atualizadas
      $args = array();
      foreach ($params as $field => $value) {
        // Separe cada coluna com seu valor correspondente
        $args[] = $field . '="' . $value . '"';
      }
      // Cria a consulta
      $sql = 'UPDATE ' . $table . ' SET ' . implode(',', $args) . ' WHERE ' . $where;

      // Faça consulta ao banco de dados
      if ($query = $this->myconn->query($sql)) {
        array_push($this->result, $this->myconn->affected_rows);
        return true; // A atualização foi bem sucedida
      } else {
        array_push($this->result, $this->myconn->error);
        return false; // A atualização não foi bem sucedida
      }
    } else {
      return false; // A tabela não existe
    }
  }

  // Função privada para verificar se a tabela existe para uso com consultas
  private function tableExists ($table) {
    $tablesInDb = $this->myconn->query('SHOW TABLES FROM ' . $this->db_name . ' LIKE "' . $table . '"');
    if ($tablesInDb) {
      if ($tablesInDb->num_rows == 1) {
        return true; // A mesa existe
      } else {
        array_push($this->result, $table . " does not exist in this database");
        return false; // A tabela não existe
      }
    }
  }

  // Função pública para retornar os dados ao usuário
  public function getResult () {
    $val = $this->result;
    $this->result = array();
    return $val;
  }
}
