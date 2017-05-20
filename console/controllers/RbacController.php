<?php
/**
 * Created by PhpStorm.
 * User: feiouzhang
 * Date: 5/19/17
 * Time: 12:59 PM
 */
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // add "createPost" privilege
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create Post';
        $auth->add($createPost);

        // add "updatePost" privilege
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update Post';
        $auth->add($updatePost);

        // add "deletePost" privilege
        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'Delete Post';
        $auth->add($deletePost);

        // add "approveComment" privilege
        $approveComment = $auth->createPermission('approveComment');
        $approveComment->description = 'Approve Comment';
        $auth->add($approveComment);


        // add "postadmin" role and assign "updatePost" “deletePost” “createPost”
        $postAdmin = $auth->createRole('postAdmin');
        $postAdmin->description = 'Post Admin';
        $auth->add($postAdmin);
        $auth->addChild($postAdmin, $updatePost);
        $auth->addChild($postAdmin, $createPost);
        $auth->addChild($postAdmin, $deletePost);

        // add "postOperator" role and assign  “deletePost”
        $postOperator = $auth->createRole('postOperator');
        $postOperator->description = 'Post Operator';
        $auth->add($postOperator);
        $auth->addChild($postOperator, $deletePost);

        // add "commentAuditor" role and assign  “approveComment”
        $commentAuditor = $auth->createRole('commentAuditor');
        $commentAuditor->description = 'Comment Auditor';
        $auth->add($commentAuditor);
        $auth->addChild($commentAuditor, $approveComment);

        // add "admin" role and assign all privilege
        $admin = $auth->createRole('admin');
        $commentAuditor->description = 'Admin';
        $auth->add($admin);
        $auth->addChild($admin, $postAdmin);
        $auth->addChild($admin, $commentAuditor);


        //assign role to user, 1 and 2 are the id returned by IdentityInterface::getId()
        //usually implement the function in the User model
        $auth->assign($admin, 1);
        $auth->assign($postAdmin, 2);
        $auth->assign($postOperator, 3);
        $auth->assign($commentAuditor, 4);
    }
}