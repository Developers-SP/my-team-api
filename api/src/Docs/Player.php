<?php 
/** @SWG\Post(
    path="/player/login",
    summary="Retrieve the player",
    tags={"Player"},
    produces={"application/json"},
    @SWG\Parameter(
        name="id",
        description="SteamID",
        in="formData",
        required=true,
        type="string",
        default=""
    ),
    @SWG\Response(
        response="200",
        description="Successful operation",
        @SWG\Schema(
            @SWG\Property(
				property="status",
				type="string"
            ),
            @SWG\Property(
				property="result",
				type="array",
				@SWG\Items(
					@SWG\Property(
					  	property="id",
				        type="integer",
				        description="Player ID"
				    ),
				    @SWG\Property(
				        property="steam_name",
				        type="string"
				    ),
				    @SWG\Property(
				        property="email",
				        type="string"
				    ),
				    @SWG\Property(
				        property="first_name",
				        type="string"
				    ),
				    @SWG\Property(
				        property="last_name",
				        type="string"
				    ),
				    @SWG\Property(
				        property="active",
				        type="integer",
				        default=1
				    ),
				    @SWG\Property(
				        property="avatar",
				        type="string"
				    ),
				    @SWG\Property(
				        property="created",
				        type="datetime"
				    ),
				    @SWG\Property(
				        property="modified",
				        type="datetime"
				    )
				)
            ),
            @SWG\Property(
				property="new",
				type="integer",
				description="Show if is a new Player"
            )
		)
    ),
    @SWG\Response(
        response=404,
        description="Player Not Found"
    ),
    @SWG\Response(
        response=400,
        description="Empty ID"
    )
)
*/
   
/** 
 @SWG\Put(
    path="/player/edit/{id}",
    summary="Edit the player",
    tags={"Player"},
    produces={"application/json"},
    @SWG\Parameter(
        name="id",
        description="SteamID",
        in="path",
        required=true,
        type="string",
        default=""
    ),
    @SWG\Parameter(
        name="email",
        description="Player E-mail",
        in="formData",
        required=false,
        type="string",
        default=""
    ),
    @SWG\Parameter(
        name="first_name",
        description="Player First Name",
        in="formData",
        required=false,
        type="string",
        default=""
    ),
    @SWG\Parameter(
        name="last_name",
        description="Player Last Name",
        in="formData",
        required=false,
        type="string",
        default=""
    ),
    @SWG\Response(
        response="200",
        description="Successful operation",
        @SWG\Schema(
            @SWG\Property(
				property="status",
				type="string",
				default="OK"
            )
		)
    ),
    @SWG\Response(
        response=404,
        description="Player Not Found"
    ),
    @SWG\Response(
        response=400,
        description="Empty ID"
    )
)
*/
   
/** 
 @SWG\Put(
    path="/player/updateBySteam/{id}",
    summary="Update Player basic data by steam API",
    tags={"Player"},
    produces={"application/json"},
    @SWG\Parameter(
        name="id",
        description="SteamID",
        in="path",
        required=true,
        type="string",
        default=""
    ),
    @SWG\Response(
        response="200",
        description="Successful operation",
        @SWG\Schema(
            @SWG\Property(
				property="status",
				type="string",
				default="OK"
            )
		)
    ),
    @SWG\Response(
        response=404,
        description="Player Not Found"
    ),
    @SWG\Response(
        response=400,
        description="Empty ID"
    )
)
*/
   
/** 
 @SWG\Get(
    path="/player/stats/{id}",
    summary="Get Player stats in Steam",
    tags={"Player"},
    produces={"application/json"},
    @SWG\Parameter(
        name="id",
        description="SteamID",
        in="path",
        required=true,
        type="string",
        default=""
    ),
    @SWG\Response(
        response="200",
        description="Successful operation",
        @SWG\Schema(
            @SWG\Property(
				property="status",
				type="string",
				default="OK"
            ),
            @SWG\Property(
				property="result",
				type="array",
				@SWG\Items(
					@SWG\Property(
					  	property="stats",
				        type="json",
				        description="All the stats of the player in CSGO",
				        default="[ { 'name': 'stat', 'value': 'quantity' } ]"
				    )
				)
            ),
		)
    ),
    @SWG\Response(
        response=404,
        description="Player Not Found"
    ),
    @SWG\Response(
        response=400,
        description="Empty ID"
    )
)
*/