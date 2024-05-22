function getCurrentDateTime() {
    const now = new Date();
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const year = String(now.getFullYear()).substr(-2);
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
  
    const formattedDateTime = `: ${day}.${month}.${year} 
    ${hours}:${minutes}:${seconds}`;
    return formattedDateTime;
  }
  
  function updateDateTime() {
    const currentDateTimeElement = document.getElementById('aktualna-data');
    if (currentDateTimeElement) {
      currentDateTimeElement.textContent = getCurrentDateTime();
    }
  }
  
  // Odświeżanie co sekundę (1000 ms)
  setInterval(updateDateTime, 1000);
  
  // Wywołanie funkcji updateDateTime po załadowaniu strony
  updateDateTime();