let recognition;
let speech = true;

document.getElementById('click_to_convert').addEventListener('click' , function(){
    window.SpeechRecognition = window.webkitSpeechRecognition;
    recognition = new SpeechRecognition();
    recognition.interimResults = true;
    recognition.maxAlternatives = 10; // Set the maxAlternatives property to 10

    recognition.addEventListener('result', e=>{
        const transcript = Array.from(e.results)
            .map(result => result[0])
            .map(result => result.transcript)
            .join('');

        convert_text.value = transcript;
    });

    if(speech == true){
        recognition.start();
    }
});

document.getElementById('stop_to_convert').addEventListener('click', function(){
    recognition.stop();
});