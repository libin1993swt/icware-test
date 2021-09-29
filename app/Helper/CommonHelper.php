<?php

use App\Models\Invitees;

function genderArray() {
    return ['Male', 'Female', 'Others'];
}

function getInviteeEmail($id) {
    $invitee = Invitees::find($id);
    return $invitee->email;
}

?>