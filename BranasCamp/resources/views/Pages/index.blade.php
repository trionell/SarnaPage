@extends('Layouts/template')
@section('content')
    
    <div class="ScaleStartPageLogo">
        <img  class="bigLogo" src="../img/branaslagret.svg" alt="Särnalägret">
        <h1 class="dateLogo">29 dec - 1 jan</h1>        
        <h1 class="dateLogo">2020 - 2021</h1>
        
        @if($camp->open > 0)
            <div class="container-fluid d-flex justify-content-center">
                <button class="buttonStyle" data-toggle="modal" data-target="#registerChoiseModal"><p>Anmäl dig!</p></button>
            </div>
        @elseif($camp->late_open > 0)
            <div class="container-fluid d-flex justify-content-center">
            <!--  <div class="container-fluid d-flex justify-content-center" style="width: 250px; margin-top: 50px; padding: 10px 10px 5px 10px; background-color: #606569;"> -->
                <!-- <h3 style="color: white;">Alla Platser är slut!</h3> -->
                <button class="buttonStyle" data-toggle="modal" data-target="#registerChoiseModal"><p>Efteranmälan</p></button>
            </div>
        @else
            <div class="container-fluid d-flex justify-content-center">
                <p class="buttonStyle" style="color: white; font-size: 27px; cursor: default;">Anmälan öppnas 10 November 18:00!</p>
            </div>
        @endif
    </div>

    @if($camp->open > 0)
        <!-- Modal normal registration-->
        <div class="modal fade" id="registerChoiseModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h4 class="text-center">Deltagare Eller Ledare?</h4>
                    </div>
                    <div class="modal-body ">
                        <div class="row">
                            <a href="/registration" class="col modalButtonStyle"><h3 class="whiteColor">Deltagare</h3></a>
                            <a href="/registration/leader" class="col modalButtonStyle"><h3 class="whiteColor">Ledare</h3></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else 

        <!-- Modal efter registrering val-->
        <div class="modal fade" id="registerChoiseModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h4 class="text-center">Deltagare Eller Ledare?</h4>
                    </div>
                    <div class="modal-body ">
                        <div class="row">
                            <button class="col modalButtonStyle lateRegTypeChoice" data-toggle="modal" data-target="#registerModal" data-dismiss="modal" data-regtype="participant"><h3 class="whiteColor">Deltagare</h3></button>
                            <button class="col modalButtonStyle lateRegTypeChoice" data-toggle="modal" data-target="#registerModal" data-dismiss="modal" data-regtype="leader"><h3 class="whiteColor">Ledare</h3></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal efter registrering-->
        <div class="modal fade" id="registerModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h4 class="text-center">Intresseanmälan</h4>
                    </div>
                    <div class="modal-body ">
                        <div class="row" style="padding: 10px; text-align:center;">
                            <p>Platserna är slut, men det går att skriva upp sig på kö ifall det blir en ledig plats.<p>
                            <p>Vi Kontaktar er via email för vidare instruktioner för riktiga anmälan om en plats skulle bli ledig.</p>
                        </div>
                        <div class="row" style="padding: 10px;">
                            <form style="width: 100%" method="POST" action="/lateregistrationsignup">
                                {{ csrf_field() }}
                                <table style="width: 100%">
                                    <tbody>
                                        <tr>
                                            <td style="width: 15%;">
                                                    <label for="name" style="float:right">Namn</label>
                                            </td>
                                            <td style="width: 85%; padding-right: 40px;">
                                                    <input type="text" id="name" name="name" style="width: 100%" placeholder="Namn Namnsson">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 15%;">
                                                <label for="email" style="float:right">Epost</label>
                                            </td>
                                            <td style="width: 85%; padding-right: 40px;">
                                                <input type="email" name="email" id="email"  style="width: 100%" placeholder="namn.namnsson@namn.se">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 15%;">
                                                <label for="phoneNumber" style="float:right">Telefonnummer</label>
                                            </td>
                                            <td style="width: 85%; padding-right: 40px;">
                                                <input type="text" name="phoneNumber" id="phoneNumber"  style="width: 100%" placeholder="0713-371337">
                                            </td>
                                        </tr>
                                        <input type="hidden" id="leader" name="leader">
                                    </tbody>                                    
                                </table>
                                <div class="container-fluid" style="text-align: center;">
                                    <i>OBS!!! Se till epost addressen är rätt ifylld! Om den är fel kommer vi inte kunna kontakta er och ni kommer förlora platsen</i>
                                </div>
                                <div class="container-fluid d-flex justify-content-center">
                                    <button type="submit" class="buttonStyle" >
                                        <p>Efteranmäl mig!</p>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
        
        
        <div class="container-fluid startPageInfo paddingBottom">
            <!--
            <h1>Plats</h1>
            <h3>Vi bor i Kvistbergskolan i Sysslebäck, Värmland. Vi åker skidor i Branäs-</h3>
            <h1>Åldersgräns</h1>
            <h3>För dig som är född 2007 eller tidigare.</h3>
            -->
        </div>

        <div class="invisibleSpacer"></div>

        <!-- What is branaslagret info -->
        <div class="container-fluid bg-white paddingBottom paddingTop" id="branaslagretInfo">
            <div class=" container centerTextInDiv">
                @foreach ($infos as $info)
                    @if($info->type == "Tom")
                        <div class="invisibleSpacer"></div>
                    @else
                        <h1>{{ $info->title }}</h1>
                        <p>{{ $info->body }}<br><br></p>
                    @endif
                @endforeach
            </div>
        </div>
        <!-- What is branaslagret end -->

        <div class="invisibleSpacer"></div>

        <!-- Pris info -->
        <!--
        <div class="container-fluid bg-white paddingBottom paddingTop" id="prisInfo">
            <div class="centerTextInDiv">
                <h1>Pris</h1>
                <h3>Lägeravgift - 1450 kr</h3>
                <br>
                <h2>Skidor och lifkort beställs senare, mer information om detta kommer med mail i december</h2>
                <h2>Liftkort (Ungdom 8-15)</h2>
                <h3>1 Dag - 260 kr</h3>
                <h3>2 Dag - 520 kr </h3>
                <h3>3 Dag - 750 kr</h3>
                <h3>4 Dag - 950 kr</h3>
                <h2><br>Liftkort (Vuxen 16+)</h2>
                <h3>1 Dag - 340 kr</h3>
                <h3>2 Dag - 660 kr </h3>
                <h3>3 Dag - 950 kr</h3>
                <h3>4 Dag - 1220 kr</h3>
                <h2><br>Skidhyra</h2>
                <h3>Skidor - 400 kr</h3>
                <h3>Snowboard - 300 kr</h3>
                <h3>Längdskidor - 100 kr</h3>
                <p>OBS! Priserna är preliminära</p>
            </div>
        </div>
    -->
        <!-- Pris info end -->
<!--
        <div class="invisibleSpacer"></div>
-->
        <!-- Regler info -->
        <div class="container-fluid bg-white paddingBottom paddingTop" id="ReglerInfo">
                <div class="container centerTextInDiv">
                    <h1>Regler</h1>
                    <h3>- Tider ska följas</h3>
                    <h3>- Ledarna är de som bestämmer</h3>
                    <h3>- Du ska vara med på de obligatoriska aktiviteterna</h3>
                    <h3>- Nolltolerans mot alkohol och droger</h3>
                <!--
                    <h3>- Avanmälan efter sista anmälningsdagen utan giltigt läkarintyg eller överenskommande med 
                        lägerledningen gör att man måste betala lägeravgiften. Eventuell kostnad för liftkort/skidhyra 
                        behöver inte betalas.
                    </h3>
                -->
                </div>
            </div>
            <!-- Regler info end -->

        <div class="invisibleSpacer"></div>

        <!-- QnA -->

        <div class="container paddingBottom">
            <div class="centerTextInDiv paddingTop" id="faqInfo">
                <h1>Frågor och svar</h1>
            </div>
            <div class="container">
                <div class="row">
                @for($i = 0; $i < $faqs->count(); $i++)
                    <!-- Left row -->
                    @if($i % 2 == 1)
                        <div class="qnaBound">
                            <!-- Question 1-->
                            <div class="col qnaBtnSize">
                                <div class="qnaBox BGGrey text-center">
                                    <div>
                                        <h2 data-toggle="collapse" href="#question{{$faqs[$i]->id}}" aria-expanded="false" aria-controls="collapseExample" class="whiteColor" style="cursor: pointer;">{{$faqs[$i]->question}}</h2>
                                    </div>
                                    <div class="collapse" id="question{{$faqs[$i]->id}}">
                                        <p class="whiteColor">{{$faqs[$i]->answer}}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Question 1 end-->
                            <!-- Add more questions here. Dont forget to change href and id for the collapse-->
                        </div>
                        <!-- Left row end-->
                    @endif
                    @endfor

                    <!-- Right row-->
                    @for($i = 0; $i < $faqs->count(); $i++)
                    @if($i % 2 == 0)
                        <div  class="qnaBound">
                            <!-- Question 2-->
                            <div class="col qnaBtnSize">
                                <div class="qnaBox BGGrey text-center">
                                    <div>
                                        <h2 data-toggle="collapse" href="#question{{$faqs[$i]->id}}" aria-expanded="false" aria-controls="collapseExample" class="whiteColor" style="cursor: pointer;">{{$faqs[$i]->question}}</h2>
                                    </div>
                                    <div class="collapse" id="question{{$faqs[$i]->id}}">
                                        <p class="whiteColor">{{$faqs[$i]->answer}}</p>
                                    </div>
                                </div>
                            </div>            
                            <!-- Question 3 end-->
                            <!-- Add more questions here. Dont forget to change href and id for the collapse-->
                        </div>
                        <!-- Right row end -->
                    @endif
                    @endfor
                </div>
            </div>
        </div>

        <!-- QnA End -->

        <div class="invisibleSpacer"></div>
        
        <!-- Kontakt info -->
        <div class="container-fluid bg-white paddingBottom paddingTop" id="KontaktInfo">
                <div class="container centerTextInDiv">
                    <h1>Kontakt</h1>
                    <div>
                        <h2>info@branaslagret.se</h2>
                    </div>
                    <!-- Kontakt lägerchefer -->
                    <div>
                        @foreach ($contact_groups as $group)
                            @if($group->populated)
                            <h2><br>{{$group->groupName}}</h2>
                            <table style="display: flex; justify-content: center;">
                                <tbody>
                                    @foreach ($contacts as $contact)
                                        @if($contact->groupID == $group->id)
                                        <tr>
                                            <td>
                                                <h5 style="margin-right: 5px;">{{$contact->name}}</h5>
                                            </td>
                                            <td>
                                                <p style="margin-top: 8px; margin-left: 5px;">{{$contact->contact_info}}</p>
                                            </td>
                                        </tr>    
                                        @endif
                                    @endforeach
                            </tbody>
                            </table>
                            @endif
                        @endforeach
                    </div>
                    <!-- Kontakt lägerchefer end -->
                </div>
            <!-- Kontakt info end -->

    </div>

    <!-- Main Site Content End -->

   

    <!-- scroll to top btn -->

    <script>

        // Scroll to top logo
        $(function(){
            $("#scrollToTopLogo").click(function(){
                $("html,body").animate({scrollTop:0},"1300");
                return false
            })
        })
        
        // Scroll to pris
        $(function(){
            $("#scrollToPrisBtn").click(function(){
                $("html,body").animate({scrollTop: $("#prisInfo").offset().top},"1300");
                return false
            })
        })
        
        // Scroll to branaslagret?
        $(function(){
            $("#scrollToBranaslagretBtn").click(function(){
                $("html,body").animate({scrollTop: $("#branaslagretInfo").offset().top},"1300");
                return false
            })
        })
        
        // Scroll to Regler
        $(function(){
            $("#scrollToReglerBtn").click(function(){
                $("html,body").animate({scrollTop: $("#ReglerInfo").offset().top},"1300");
                return false 
            })
        })

        
        // Scroll to faq
        $(function(){
            $("#scrollTofaqBtn").click(function(){
                $("html,body").animate({scrollTop: $("#faqInfo").offset().top},"1300");
                return false
            })
        })

        
        // Scroll to kontakt
        $(function(){
            $("#scrollToKontaktBtn").click(function(){
                $("html,body").animate({scrollTop: $("#KontaktInfo").offset().top},"1000");
                return false
            })
        })

        $(function(){
            $(".lateRegTypeChoice").click(function(){
                console.log($(this).data("regtype"));
                
                var $target = $(event.target);
                if($(this).data("regtype") == "leader"){
                    console.log("Found type: leader");
                    $("#leader").val(1);
                }
                else{
                    console.log("Found type: participant");
                    $("#leader").val(0);
                }
            })
        })

    </script>
    <!-- scroll to top btn end -->
    
    @endsection