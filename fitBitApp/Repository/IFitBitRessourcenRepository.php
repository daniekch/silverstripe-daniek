<?php

interface IFitBitRessourcenRepository {
	
	/*
	 * Load member data.
	 */
	public function LoadMember($userdata);
	
	/*
	 * Get FitBit member by ID from user repository
	 */
	public function GetMember($userid);
	
	/*
	 * Create a new FitBit member
	 */
	public function CreateMember($userid);
	
	/*
	 * Load profil data
	 */
	public function LoadProfil($member, $accessToken, $forceRefresh);
	
	/*
	 * Get profil information.
	 */
	public function GetProfil($member);
	
	/*
	 * Create profil information.
	 */
	public function CreateProfil($member, $accessToken);
	
	/*
	 * Load activities from given user.
	 */
	public function LoadActivities($member, $accessToken, $forceRefresh, $date);
	
	/*
	 * Get activities from fitbit api.
	 */
	public function GetActivities($member);
	
	/*
	 * Create activities from fitbit and save it.
	 */
	public function CreateActivities($member, $accessToken, $date);
	
	/*
	 * Load devices from given user.
	 */
	public function LoadDevices($member, $accessToken, $forceRefresh);
	
	/*
	 * Get devices connected to a user account
	 */
	public function GetDevices($member);
	
	/*
	 * Create devices from fitbit and save it.
	 */
	public function CreateDevices($member, $accessToken);
}