document.addEventListener('DOMContentLoaded', function() {
    const accountNumberSelect = document.getElementById('account_number');

   
    function fetchAccounts() {
        fetch('fetch_accounts.php')
            .then(response => response.json())
            .then(data => {
                accountNumberSelect.innerHTML = ''; 
                data.forEach(account => {
                    const option = document.createElement('option');
                    option.value = account.account_number;
                    option.textContent = account.account_number;
                    accountNumberSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching account numbers:', error);
            });
    }
    fetchAccounts();
    accountNumberSelect.addEventListener('click', fetchAccounts);
    accountNumberSelect.addEventListener('focus', fetchAccounts);
});
