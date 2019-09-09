<?php
namespace App\Controller;

use App\Utils\RedisSession;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\Token;
use App\Utils\Response;
use Psr\Log\LoggerInterface;

/**
 * LoginController
 * 
 * mocked, needed to get token string and add data to redis session 
 */
class LoginController extends AbstractController
{
    /**
     * @Route("/user/login/", name="userlogin", methods={"GET"})
     */
    public function login(RedisSession $rsession, LoggerInterface $logger)
    {
        try {
            $output = ['status'=>'OK'];
            
            $userData = array(
                'id' => '181718',
            );
            $token = $rsession->generateToken(new Token());
            $res = $rsession->set($token, json_encode($userData));
            
            $output['token'] = $token;
            
            return new Response($output);          
        } catch (\Exception $e) {
            $logger->critical($e->getMessage());
            
            $output['status'] = 'ERROR';
            $output['msg'] = 'internal error'.$e->getMessage();
            
            return new Response($output, 500);
        }
    }
}