<?php

$name = isset($_POST['name'])? htmlspecialchars($_POST['name']) : "";
$email = isset($_POST['email'])? htmlspecialchars($_POST['email']) : "";
$phone = isset($_POST['phone'])? htmlspecialchars($_POST['phone']) : "";
$comment = isset($_POST['comment'])? htmlspecialchars($_POST['comment']) : "";

mail("info@astra-group.ca", 'Astra-management - New Contact Form', 
	"Astra-management - New Contact. Name - $name, Email - $email, Phone - $phone, Comment - $comment");