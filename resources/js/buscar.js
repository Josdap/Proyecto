

    // Obtener elementos HTML
    const searchInput = document.getElementById('search-input');
    const proveedorTable = document.getElementById('table');

    // Agregar evento de entrada en el campo de búsqueda
    searchInput.addEventListener('input', function(event) {
        const searchTerm = event.target.value.toLowerCase();
        const rows = proveedorTable.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) { // Comenzar desde 1 para omitir la fila de encabezados
            const row = rows[i];
            const columns = row.getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < columns.length; j++) {
                const column = columns[j];
                if (column.textContent.toLowerCase().includes(searchTerm)) {
                    found = true;
                    break;
                }
            }

            if (found) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
