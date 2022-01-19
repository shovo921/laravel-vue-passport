<?php

/*
 * sucess messege show*/
function send_sucess($messege ,$data){

    $response=[
        'status'=> true,
        'messege'=> $messege,
        'data'=>$data
    ];
    return response()->json([$messege,$response]);
}



/*
 * error messege show
 * */
function send_error($messege, $messeges=[],$code=404)
{


    $response=[
       'status'=> false,
      'messege'=> $messege,

    ];
    !empty($messeges) ? $response['errors'] =$messeges :null;
    return response()->json([
       $response,
       $code,


   ]);
}
