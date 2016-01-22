<?php
/**
 * Created by PhpStorm.
 * User: juzi
 * Date: 2014/12/17
 * Time: 21:20
 * 依赖注入对象管理
 */

//
Yii::$container->set('M_LeUcenterMember','member\models\LeUcenterMemberDB');

Yii::$container->set('M_LeAuthGroup','member\models\LeAuthGroupDB');

Yii::$container->set('M_LeAuthRule','member\models\LeAuthRuleDB');

Yii::$container->set('M_LeEmail','member\models\LeEmailDB');