<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-25 17:16:50
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-29 14:16:32
 */


namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Bound\ApiBundle\Controller\AController;
use Bound\CoreBundle\Entity\Token;
use Bound\CoreBundle\Entity\User;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\Post;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializerBuilder;

class TokenController extends AController {

    /**
     * Mapping [POST] api.bound-app.com/token"
     * @Post("/token")
     * @ApiDoc(
     *  description="Vérifier qu'un token existe",
     *  output="Bound\CoreBundle\Entity\User",
     *  parameters={
     *      {
     *          "name"="token",
     *          "dataType"="string",
     *          "description"="Token",
     *          "required"="true"
     *      }
     *     
     *  },
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     400="Retourner si la requête n'est pas bien formatée",
     *     403="Retourner si l'utilisateur n'existe pas"
     *  }
     * )
     */
    public function tokenAction(Request $request) {
        $token = $request->get('token');

        if ($token) {
            $user = $this->assertToken($token);

            return $user;
        } else {
            throw new HttpException(400, "Bad Request.");
        }
    }
}
