<?php

namespace App\Helper;

use App\Entity\Publicacao;
use App\Interface\PublicacaoInterface;
use Doctrine\ORM\EntityManagerInterface;

class PublicacaoFactory implements PublicacaoInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function salvarImagem($dadosImagem): String
    {
        $extencaoAtualDoArquivo = explode(
            '.',
            $dadosImagem['file']['name']
        )[count(explode('.', $dadosImagem['file']['name'])) - 1];

        $novoNomeArquivo = uniqid('', true) . '.' . $extencaoAtualDoArquivo;
        $destinoDoArquivo = 'C:/Users/Paulo/Documents/A1_Programação/A8_Portifólio/17 MeuBlog/Api/public/assets/fotos/' . $novoNomeArquivo;

        move_uploaded_file($dadosImagem['file']['tmp_name'], $destinoDoArquivo);

        return $novoNomeArquivo;
    }

    public function salvarPublicacao($dados)
    {
        $publicacao = (new Publicacao())
            ->setTitulo($dados['titulo'])
            ->setTexto($dados['conteudo'])
            ->setCategoria($dados['categoria'])
            ->setNomeFoto($dados['nomeImagem']);

        $this->entityManager->persist($publicacao);
        $this->entityManager->flush();

        return $publicacao;
    }
}
