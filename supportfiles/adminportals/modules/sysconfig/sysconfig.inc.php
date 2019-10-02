<?php

/**
 *@license
 *Copyright (c) 2019 Cisco and/or its affiliates.
 *
 *This software is licensed to you under the terms of the Cisco Sample
 *Code License, Version 1.1 (the "License"). You may obtain a copy of the
 *License at
 *
 *			   https://developer.cisco.com/docs/licenses
 *
 *All use of the material herein must be in accordance with the terms of
 *the License. All rights not expressly granted by the License are
 *reserved. Unless required by applicable law or agreed to separately in
 *writing, software distributed under the License is distributed on an "AS
 *IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 *or implied.
 */
	
	
	$portsAndProtocolsOutput = "";
	$hostnameOutput = "";
	
	$adminPortalSettings = $ipskISEDB->getGlobalClassSetting("admin-portal");
	$iseERSSettings = $ipskISEDB->getGlobalClassSetting("ise-ers-credentials");
	$iseMNTSettings = $ipskISEDB->getGlobalClassSetting("ise-mnt-credentials");
	$smtpSettings = $ipskISEDB->getGlobalClassSetting("smtp-settings");
	$hostnameListing = $ipskISEDB->getHostnameList();	
	$portsAndProtocols = $ipskISEDB->getTcpPortList();
	
	if(isset($adminPortalSettings['admin-portal-strict-hostname'])){
		if($adminPortalSettings['admin-portal-strict-hostname'] == 1){
			$adminPortalSettings['admin-portal-strict-hostname'] = " checked";
			$adminPortalSettings['admin-portal-strict-hostname-value'] = "1";
		}else{
			$adminPortalSettings['admin-portal-strict-hostname'] = "";
			$adminPortalSettings['admin-portal-strict-hostname-value'] = "0";
		}
	}else{
		$adminPortalSettings['admin-portal-strict-hostname'] = "";
		$adminPortalSettings['admin-portal-strict-hostname-value'] = "0";
	}
	
	if(isset($adminPortalSettings['redirect-on-hostname-match'])){
		if($adminPortalSettings['redirect-on-hostname-match'] == 1){
			$adminPortalSettings['redirect-on-hostname-match'] = " checked";
			$adminPortalSettings['redirect-on-hostname-match-value'] = "1";
		}else{
			$adminPortalSettings['redirect-on-hostname-match'] = "";
			$adminPortalSettings['redirect-on-hostname-match-value'] = "0";
		}
	}else{
		$adminPortalSettings['redirect-on-hostname-match'] = "";
		$adminPortalSettings['redirect-on-hostname-match-value'] = "0";
	}
	
	if(isset($iseERSSettings['enabled'])){
		if($iseERSSettings['enabled'] == 1){
			$iseERSSettings['enabled-check'] = " checked";
		}else{
			$iseERSSettings['enabled-check'] = "";
		}
	}else{
		$iseERSSettings['enabled-check'] = "";
	}
	
	if(isset($iseERSSettings['verify-ssl-peer'])){
		if($iseERSSettings['verify-ssl-peer'] == 1){
			$iseERSSettings['verify-ssl-peer-check'] = " checked";
		}else{
			$iseERSSettings['verify-ssl-peer-check'] = "";
		}
	}else{
		$iseERSSettings['verify-ssl-peer'] = true;
		$iseERSSettings['verify-ssl-peer-check'] = " checked";
	}
	
	if(isset($iseMNTSettings['enabled'])){
		if($iseMNTSettings['enabled'] == 1){
			$iseMNTSettings['enabled-check'] = " checked";
		}else{
			$iseMNTSettings['enabled-check'] = "";
		}
	}else{
		$iseMNTSettings['enabled-check'] = "";
	}	
	
	if(isset($iseMNTSettings['verify-ssl-peer'])){
		if($iseMNTSettings['verify-ssl-peer'] == 1){
			$iseMNTSettings['verify-ssl-peer-check'] = " checked";
		}else{
			$iseMNTSettings['verify-ssl-peer-check'] = "";
		}
	}else{
		$iseMNTSettings['verify-ssl-peer'] = true;
		$iseMNTSettings['verify-ssl-peer-check'] = " checked";
	}

	if(isset($smtpSettings['enabled'])){
		if($smtpSettings['enabled'] == 1){
			$smtpSettings['enabled-check'] = " checked";
		}else{
			$smtpSettings['enabled-check'] = "";
		}
	}else{
		$smtpSettings['enabled-check'] = "";
	}

	if($portsAndProtocols){
		if($portsAndProtocols->num_rows > 0){
			while($row = $portsAndProtocols->fetch_assoc()){
				if($row['portalSecure'] == 1){
					$protocol = "HTTPS";
				}else{
					$protocol = "HTTP";
				}
				
				$portsAndProtocolsOutput .= "<option value=\"{$row['id']}\">$protocol ({$row['portalPort']})</option>";
			}
		}
	}
	
	if($hostnameListing){
		if($hostnameListing->num_rows > 0){
			while($row = $hostnameListing->fetch_assoc()){
				$hostnameOutput .= "<option value=\"{$row['id']}\">{$row['hostname']}</option>";
			}
		}
	}

?>
<div class="row">
	<div class="col-12"><h1 class="text-center">Platform Settings</h1></div>
</div>
<div class="row">
	<div class="col"><hr></div>
</div>
<nav>
	<div class="nav nav-tabs" id="nav-tab" role="tablist">
		<a class="nav-item nav-link active" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="true">General</a>
		<a class="nav-item nav-link" id="nav-hostname-tab" data-toggle="tab" href="#nav-hostname" role="tab" aria-controls="nav-hostname" aria-selected="false">Portal Hostnames</a>
		<a class="nav-item nav-link" id="nav-proto-tab" data-toggle="tab" href="#nav-proto" role="tab" aria-controls="nav-proto" aria-selected="false">Ports & Protocols</a>
		<a class="nav-item nav-link" id="nav-ise-tab" data-toggle="tab" href="#nav-ise" role="tab" aria-controls="nav-ise" aria-selected="false">Cisco ISE Integration</a>
		<a class="nav-item nav-link" id="nav-smtp-tab" data-toggle="tab" href="#nav-smtp" role="tab" aria-controls="nav-smtp" aria-selected="false">SMTP Configuration</a>
	</div>
</nav>
<div class="tab-content" id="nav-tabContent">
	<div class="tab-pane fade show active" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab"><?php include("general.inc.php");?></div>
	<div class="tab-pane fade" id="nav-hostname" role="tabpanel" aria-labelledby="nav-hostname-tab"><?php include("hostnames.inc.php");?></div>
	<div class="tab-pane fade" id="nav-proto" role="tabpanel" aria-labelledby="nav-proto-tab"><?php include("protocols.inc.php");?></div>
	<div class="tab-pane fade" id="nav-ise" role="tabpanel" aria-labelledby="nav-ise-tab"><?php include("ise.inc.php");?></div>
	<div class="tab-pane fade" id="nav-smtp" role="tabpanel" aria-labelledby="nav-smtp-tab"><?php include("smtp.inc.php");?></div>
</div>

<script>

	$(".checkbox-update").change(function(){
		if($(this).prop('checked')){
			$(this).attr('value', $(this).attr('base-value'));		
		}else{
			$(this).attr('value', '0');
		}
	});
	
	$(".generaltab").change(function(){
		$("#updategeneral").removeAttr('disabled');
	});
	
	$(".iseers").change(function(){
		$("#updateersise").removeAttr('disabled');
	});
	
	$(".isemnt").change(function(){
		$("#updatemntise").removeAttr('disabled');
	});
	
	$("#ersPassword").change(function(){
		$("#seterspass").removeAttr('disabled');
	});
	
	$("#mntPassword").change(function(){
		$("#setmntpass").removeAttr('disabled');
	});

	$(".smtpupdate").change(function(){
		$("#updatesmtp").removeAttr('disabled');
	});
	
	$("#smtpPassword").change(function(){
		$("#setsmtppass").removeAttr('disabled');
	});

	$("#updategeneral").click(function(){
		event.preventDefault();

		$.ajax({
			url: "ajax/getmodule.php",
			
			data: {
				module: $(this).attr('module'),
				'sub-module': $(this).attr('sub-module'),
				'module-action': $(this).attr('module-action'),
				adminPortalHostname: $("#adminPortalHostname").val(),
				'strict-hostname': $("#strictHostname").val(),
				'redirect-hostname': $("#redirectOnHostname").val()				
			},
			type: "POST",
			dataType: "text",
			success: function (data) {
					if(data != 0){
						$("#updategeneral").attr("disabled", true);
					}
			}
		});
	});
	
	$("#addhostname").click(function(){
		event.preventDefault();

		$.ajax({
			url: "ajax/getmodule.php",
			
			data: {
				module: $(this).attr('module'),
				'sub-module': $(this).attr('sub-module'),
				'module-action': $(this).attr('module-action'),
				hostname: $("#hostname").val()
			},
			type: "POST",
			dataType: "text",
			success: function (data) {
					if(data == 0){
						$("#portalHostname").val('');
					}else{
						var temp = $('<option>', {value: data});
						$("#portalHostname").append(temp.html($("#hostname").val()));
						$("#hostname").val("");
					}
			}
		});
	});
	
	$("#deletehostname").click(function(){
		event.preventDefault();

		$.ajax({
			url: "ajax/getmodule.php",
			
			data: {
				module: $(this).attr('module'),
				'sub-module': $(this).attr('sub-module'),
				id: $("#portalHostname").val(),
				'module-action': $(this).attr('module-action')
			},
			type: "POST",
			dataType: "text",
			success: function (data) {
					if(data == 1){
						$("#portalHostname").find("option:selected").remove();
					}
			}
		});
	});
	
	$("#addprotocol").click(function(){
		event.preventDefault();

		$.ajax({
			url: "ajax/getmodule.php",
			
			data: {
				module: $(this).attr('module'),
				'sub-module': $(this).attr('sub-module'),
				'module-action': $(this).attr('module-action'),
				protocol: $("#protocol").val(),
				portalPort: $("#portalPort").val()
			},
			type: "POST",
			dataType: "text",
			success: function (data) {
					if(data == 0){
						$("#portalPort").val('');
					}else{
						var temp = $('<option>', {value: data});
						var portalProtocol = $("#protocol option:selected").text();
						var portalPort = $("#portalPort").val();
						$("#protocolPorts").append(temp.html(portalProtocol + " (" + portalPort + ")"));
						$("#portalPort").val("");
					}
			}
		});
	});
	
	$("#deleteprotocol").click(function(){
		event.preventDefault();

		$.ajax({
			url: "ajax/getmodule.php",
			
			data: {
				module: $(this).attr('module'),
				'sub-module': $(this).attr('sub-module'),
				id: $("#protocolPorts").val(),
				'module-action': $(this).attr('module-action')
			},
			type: "POST",
			dataType: "text",
			success: function (data) {
					if(data == 1){
						$("#protocolPorts").find("option:selected").remove();
					}
			}
		});
	});
	
	$("#updateersise").click(function(){
		event.preventDefault();

		$.ajax({
			url: "ajax/getmodule.php",
			
			data: {
				module: $(this).attr('module'),
				'sub-module': $(this).attr('sub-module'),
				'module-action': $(this).attr('module-action'),
				ersEnabled: $("#ersEnabled").val(),
				ersHost: $("#ersHost").val(),
				ersUsername: $("#ersUsername").val(),
				ersVerifySsl: $("#ersVerifySsl").val()
			},
			type: "POST",
			dataType: "text",
			success: function (data) {
					if(data != 0){
						$("#updateersise").attr("disabled", true);
					}
			}
		});
	});
	
	$("#updatemntise").click(function(){
		event.preventDefault();

		$.ajax({
			url: "ajax/getmodule.php",
			
			data: {
				module: $(this).attr('module'),
				'sub-module': $(this).attr('sub-module'),
				'module-action': $(this).attr('module-action'),
				mntEnabled: $("#mntEnabled").val(),
				mntHost: $("#mntHostPrimary").val(),
				mntUsername: $("#mntUsername").val(),
				mntVerifySsl: $("#mntVerifySsl").val()
			},
			type: "POST",
			dataType: "text",
			success: function (data) {
					if(data != 0){
						$("#updatemntise").attr("disabled", true);
					}
			}
		});
	});
	
	$("#seterspass").click(function(){
		event.preventDefault();

		$.ajax({
			url: "ajax/getmodule.php",
			
			data: {
				module: $(this).attr('module'),
				'sub-module': $(this).attr('sub-module'),
				'module-action': $(this).attr('module-action'),
				ersPassword: $("#ersPassword").val()
			},
			type: "POST",
			dataType: "text",
			success: function (data) {
					if(data != 0){
						$("#seterspass").attr("disabled", true);
					}
			}
		});
	});
	
	$("#setmntpass").click(function(){
		event.preventDefault();

		$.ajax({
			url: "ajax/getmodule.php",
			
			data: {
				module: $(this).attr('module'),
				'sub-module': $(this).attr('sub-module'),
				'module-action': $(this).attr('module-action'),
				mntPassword: $("#mntPassword").val()
			},
			type: "POST",
			dataType: "text",
			success: function (data) {
					if(data != 0){
						$("#setmntpass").attr("disabled", true);
					}
			}
		});
	});
	
	$("#updatesmtp").click(function(){
		event.preventDefault();

		$.ajax({
			url: "ajax/getmodule.php",
			
			data: {
				module: $(this).attr('module'),
				'sub-module': $(this).attr('sub-module'),
				'module-action': $(this).attr('module-action'),
				smtpHost: $("#smtpHost").val(),
				smtpPort: $("#smtpPort").val(),
				smtpUsername: $("#smtpUsername").val(),
				smtpFromAddress: $("#smtpFromAddress").val(),
				smtpEnabled: $("#smtpEnabled").val()
			},
			type: "POST",
			dataType: "text",
			success: function (data) {
					if(data != 0){
						$("#updatesmtp").attr("disabled", true);
					}
			}
		});
	});
	
	$("#setsmtppass").click(function(){
		event.preventDefault();

		$.ajax({
			url: "ajax/getmodule.php",
			
			data: {
				module: $(this).attr('module'),
				'sub-module': $(this).attr('sub-module'),
				'module-action': $(this).attr('module-action'),
				smtpPassword: $("#smtpPassword").val()
			},
			type: "POST",
			dataType: "text",
			success: function (data) {
					if(data != 0){
						$("#setsmtppass").attr("disabled", true);
					}
			}
		});
	});
</script>