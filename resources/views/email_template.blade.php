<div style="text-align:center;width:70%;margin:auto;">
    <h1>Hello {{$data['name']}}</h1>
    <h3 style="background:darkcyan;padding:10px 20px; color:#fff;border-radius:5px;">
        Here is your reset password 
        <a style="color:#fff;" href='http://localhost:3000/reset/{{$data['token']}}'>Link</a>
    </h3>
</div>