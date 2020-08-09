@extends('layouts.app')
@push('styles')
<style type="text/css">
    @keyframes rotate{
        from{
            transform:rotate(0deg);
        }
        to{
            transform:rotate(360deg);
        }
    }
    .refresh{
        animation: rotate 1.5s linear infinite;
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Game') }}</div>

                <div class="card-body">
                    <div class="text-center">
                        <img id="circle" class="" width="250" height="250" src="{{ asset('img/circle.png') }}">
                        <p id="winner" class="display-1 d-none text-primary">10</p>
                    </div>
                    <hr>
                    <div class="text-center">
                        <label class="font-weight-bold h5">Your bet</label>
                        <select class="custom-select col-auto" id="bet">
                            <option selected>Not in</option>
                            @foreach(range(1, 12) as $number)
                                <option>{{ $number}}</option>
                            @endforeach
                        </select>
                        <hr>
                        <p class="font-weight-bold h5">Remaining Time</p>
                        <p id="timer" class="h5 text-danger">Waiting to start</p>
                        <hr>
                        <p id="result" class="h1"></p>
                        <hr>
                        <button id="start">Start Game</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    const button = document.getElementById('start');
    button.onclick = function(){
        window.axios.get('start_game').then((res)=>{
        console.log(res);
        })
    }

</script>
<script>
    const circleElement = document.getElementById('circle');
    const timerElement = document.getElementById('timer');
    const winnerElement = document.getElementById('winner');
    const betElement = document.getElementById('bet');
    const resultElement = document.getElementById('result');

    window.Echo.channel('game')
        .listen('RemainingTimeChanged', (e)=>{
            console.log(e.time)
            timerElement.innerText = e.time;
            circleElement.classList.add('refresh');
            winnerElement.classList.add('d-none'); //por si ya se habia ejecutado antes
            resultElement.innerText = ''; //por si ya se habia ejecutado antes

            winnerElement.classList.remove('text-success'); //por si ya se habia ejecutado antes
            winnerElement.classList.remove('text-danger'); //por si ya se habia ejecutado antes
        })
        .listen('WinnerNumberGenerated', (e) => {
            circleElement.classList.remove('refresh');

            let winner = e.number;
            winnerElement.innerText = winner;
            winnerElement.classList.remove('d-none');

            let bet = betElement[betElement.selectedIndex].innerText;
            if(bet == winner){
                resultElement.innerText = 'You WIN';
                resultElement.classList.add('text-success'); 
            }else{
                resultElement.innerText = 'You LOSE';
                resultElement.classList.add('text-danger'); 
            }
        })
</script>
@endpush