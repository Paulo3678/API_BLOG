<?php

namespace App\Controller;

use App\Entity\Publicacao;
use App\Helper\CacheFactory;
use App\Helper\ResponseFactory;
use App\Interface\PublicacaoInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublicacoesController extends AbstractController
{
    private $repositorioDePulicacoes;
    private $publicacoesFactory;
    private $cache;

    public function __construct(
        EntityManagerInterface $entityManager,
        PublicacaoInterface $publicacoesFactory,
        CacheItemPoolInterface $cache
    ) {
        $this->entityManager = $entityManager;
        $this->repositorioDePulicacoes = $entityManager->getRepository(Publicacao::class);
        $this->publicacoesFactory = $publicacoesFactory;
        $this->cache = $cache;
    }

    // RETURN EVERY PUBLICACAO OR A QUANTITY PASSED BY QUERY
    public function getPublicacoes(Request $request): Response
    {
        $categoria = $request->query->all();
        unset($categoria['quantidade']);

        if (!isset($request->query->all()['quantidade'])) {
            $response = ResponseFactory::responseMaker(
                $this->repositorioDePulicacoes->findBy($categoria),
                $request
            );
            return new JsonResponse($response, 200);
        }

        $quantidade = $request->query->all()['quantidade'];
        $response = ResponseFactory::responseMaker(
            $this->repositorioDePulicacoes->findBy($categoria, [], $quantidade),
            $request
        );

        return new JsonResponse($response, 200);
    }

    // RETURN ONLY ONE PUBLICACAO
    public function getPublicacao(int $id): Response
    {
        if ($this->cache->hasItem('publicacao_' . $id)) {
            return new JsonResponse($this->cache->getItem('publicacao_' . $id)->get());
        }

        $publicacao = $this->repositorioDePulicacoes->findOneBy(['id' => $id]);

        return new JsonResponse($publicacao, 200);
    }

    // SEARCH FOR PUBLICACAO BY A POSITION
    public function searchMore(Request $request): Response
    {
        return new JsonResponse(
            ResponseFactory::responseMaker(
                $this->repositorioDePulicacoes->findBy([], [], $_GET['quantidade'], $request->query->get('posicao')),
                $request
            ),
            200
        );
    }

    // RETURN AN IMAGE
    public function getImage(): Response
    {

        header("Content-Type: image/jpg");
        $extencaoArquivo = (explode('.', $_GET['nomeFoto']))[count(explode('.', $_GET['nomeFoto'])) - 1];

        if (!in_array($extencaoArquivo, ['jpg', 'jpeg', 'png'])) {
            return new Response('', 404);
        }
        return new Response(
            require  __DIR__ . "/../../public/assets/fotos/{$_GET['nomeFoto']}",
            200,
            ["Content-Type" => "image/jpg"]
        );
    }

    // TO GET AND TO SAVE AN PUBLICACAO
    public function setPublicacao(Request $request): Response
    {
        $json = $request->getContent();
        $dados = json_decode($json, true);
        $publicacao = $this->publicacoesFactory->salvarPublicacao($dados);

        $response = ResponseFactory::responseMaker(
            ["publicacao" => $this->publicacoesFactory->salvarPublicacao($dados)],
            $request
        );

        CacheFactory::saveCacheObject($this->cache, $publicacao);

        return new JsonResponse($response, Response::HTTP_OK);
    }

    // TO GET AND TO SAVE AN IMAGE
    public function image(Request $request): Response
    {
        $reponse = ResponseFactory::responseMaker(
            ["nomeFoto" => $this->publicacoesFactory->salvarImagem($_FILES)],
            $request
        );
        return new JsonResponse($reponse, 200);
    }
}
