document.getElementById('datetime-local').addEventListener('input', function(event) {
    let input = event.target;
    let value = input.value;
    
    if (value) {
        let date = new Date(value);
        let minutes = date.getMinutes();

        // Устанавливаем шаг в 10 минут
        let adjustedMinutes = Math.round(minutes / 10) * 10;
        date.setMinutes(adjustedMinutes);
        
        // Форматируем дату в строку и обновляем значение input
        input.value = date.toISOString().slice(0, 16);
    }
});
