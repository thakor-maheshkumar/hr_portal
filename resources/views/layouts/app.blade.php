<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/ico" href="{{asset('/images/logo/'. $setting->favicon)}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <!--[if IE]>
    <link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
    <![endif]-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{$setting->welcome_txt}}</title>

    <!-- Styles -->
    @yield('head')

</head>
<body>
    <div id="app" style="position: relative;">
        @yield('top_bar')
        @yield('content')
        <br>
        <br>
    </div>
    @php
     $ct = App\copyrighttext::where('id','=',1)->first();
    @endphp
   <div style="padding:15px;color: #FFF;background-color:#424242; position: fixed; width: 100%; bottom: 0;">
        <div class="container" >
            <div class="row">
                <div class="col-md-6">
                    {{ $ct->name }}
                </div>
                <div class="col-md-6">
                    @php
                    $si = App\SocialIcons::all();
                    @endphp
                    @foreach($si as $s)
                    @if($s->status==1)
                        <a target="_blank" title="Visit {{ $s->title }}" href="{{ $s->url }}"><img width="32px" src="{{ asset('images/socialicons/'.$s->icon) }}" alt="{{ $s->title }}" title="{{ $s->title }}" style="margin-top:-5px;"></a>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
      $(function () {
        $( document ).ready(function() {
           $('.sessionmodal').addClass("active");
           setTimeout(function() {
               $('.sessionmodal').removeClass("active");
          }, 4500);

           $( "#datepickerdob" ).datepicker({ 
                dateFormat: 'mm/dd',
                beforeShow: function (input, inst) {

                inst.dpDiv.addClass('BirthdayDatePicker');
            },
            onClose: function(dateText, inst){
                inst.dpDiv.removeClass('BirthdayDatePicker');
            }
           });

           $( "#date" ).datepicker({ 
                dateFormat: 'mm/dd/yy',
                changeMonth: true,
                changeYear: true,
                minDate: 0
           });

        });
        $('#userform').validate({
            errorClass:'errorsData',
             rules: {
                resume: {
                required: true,
                extension: "pdf|doc|docx"
                    },
                },
            messages:{
                resume:{
                    //required:'hello',
                    extension:'Please enter valid file type',
                }
                
            },
  
        });
      });
$(document).ready(function(){
  $('input[name=others').click(function() {
    if (this.checked) {
        $('.jobopportunity').show();
    }
    else {
        $('.jobopportunity').hide();
    }
});
 })
    </script>
    @yield('scripts')
</body>
</html>
