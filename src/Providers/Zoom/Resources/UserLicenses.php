<?php

namespace Nncodes\Meeting\Providers\Zoom\Resources;

class UserLicenses
{
    /**
     * A basic user is user without a paid license. 
    * A basic user can host meetings with up to 100 participants. 
    * If 3 or more participants join, the meeting will time out after 40 minutes. 
    * They cannot utilize user and account add-ons such as large meeting, webinar, or conference room connector. 
    * 
    * @var int 
    */
    CONST BASIC = 1;

     /**
    * A licensed user is a paid account user who can host unlimited meetings on the public cloud. 
    * By default, they can host meetings with up to 100 participants and large meeting licenses are available for additional capacity.
    *
    * @var int 
    */
    CONST LICENSED = 2;

    /**
    * A on-prem user is a paid account who can host unlimited meetings with the on-premise meeting connector
    * 
    * @var int 
    */
    CONST ON_PREM = 3;

    

}