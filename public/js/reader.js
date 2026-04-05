let speech;

function readPage() {
  const content = document.querySelector("main") 
    ? document.querySelector("main").innerText
    : document.body.innerText;

  speech = new SpeechSynthesisUtterance(content);
  speech.lang = "en-US";   // ar-EG للعربي
  speech.rate = 1;
  speech.pitch = 1;

  window.speechSynthesis.speak(speech);
}

function stopReading() {
  window.speechSynthesis.cancel();
}
