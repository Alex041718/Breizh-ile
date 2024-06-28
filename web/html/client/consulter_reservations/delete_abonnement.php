<?php

require_once '../../../services/SubscriptionService.php';

$subscription = SubscriptionService::getSubscriptionByToken($_POST['token']);

SubscriptionService::deleteSubscriptionByToken($subscription);