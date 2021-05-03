<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                
                background-position: center;
                  background-repeat: no-repeat;
                  background-size: cover;
                background-image: url("images/comp.jpeg") ;
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100%;
                margin: 0;
            }

            .full-height {
                
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .box-1{
               position: relative;
                width: 50%;
                background-color: #e1f8ff;
                border-radius: 6px;
                text-align: center;
                
                padding: 40px;
                top:130px;
                left: 400px;
                box-shadow: 5px 10px 3px ;
            }
            .inside-box{
                font-size: 40px;
                font-family: "Lucida Console", Monaco, monospace;
            }

            .box-2{
               position: absolute;
                width: 50%;
                background-color: #e1f8ff;
                border-radius: 6px;
                
                
                padding: 40px;
                top:340px;
                left: 400px;
                box-shadow: 5px 10px 3px ;
            }
            .inside-box2{
                font-size: 25px;
                font-family: "Lucida Console", Monaco, monospace;
                
                
            }
             ul.a {
            list-style-type: circle;
            
            }


        </style>
    </head>
    <body>
        
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a style="color:black ;font-size:20px" href="{{ route('login') }}">se connecter</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

           
       

         <div class="box-1" >
             <div class="inside-box">
            Espace étudiant
             </div>
         </div>


         <div class="box-2" >
             
            <div class="inside-box2">
                <ul class="a">
                    <li >Espace pour repondre aux qcm proposé par votre professeur(pargroupe)</li>
                    <li >en raffraichissment de la page le qcm est validé (tu peux pas repondre une dexuième fois)</li>
                    <li>Seul les admins ( professeur) on le droit de creer qcm</li>
                    <li>Si le temps est terminé les reponses  selectionné vont etre validé </li>
                    <li>vous pouvez voir votre note instantanément </li>
                   
                  </ul>
          
            </div>
        </div>
         
         

    </body>
</html>
