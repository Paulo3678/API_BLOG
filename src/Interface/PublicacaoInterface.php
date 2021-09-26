<?php

namespace App\Interface;

interface PublicacaoInterface{
    public function salvarImagem($dadosImagem): String;
    public function salvarPublicacao($dados);
}
