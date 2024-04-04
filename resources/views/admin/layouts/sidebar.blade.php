<div class="d-flex">
    <div class="sidebar flex-shrink-0 p-3" style="width: 240px;">
        <a href="/home" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img class="sidebar-brand-icon" src="{{ asset('images/budgeting.png') }}" alt="App Icon">
            <span>Budgeting App</span>
        </a>
        <hr class="sidebar-divider">
        <ul class="nav nav-pills flex-column" id="sidebar">
            <li class="nav-item">
                <a href="/home" class="nav-link" aria-current="page">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
                        <li>
                <a class="nav-link" href="{{ route('category.index') }}">
                    <i class="fas fa-fw fa-list-alt"></i> <!-- Change icon class here -->
                    Budgets
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('expenses.index') }}">
                    <i class="fas fa-fw fa-receipt"></i> <!-- Change icon class here -->
                    Expenses
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('debts.index') }}">
                    <i class="fas fa-fw fa-wallet"></i>
                    Debts
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('debits.index') }}">
                    <i class="fas fa-fw fa-hand-holding-usd"></i>
                    Direct Debits
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('finances.index') }}">
                    <i class="fas fa-fw fa-university"></i>
                    Student Finance
                </a>
            </li>
        </ul>
        <hr class="sidebar-divider">
          <div class="sidebar-heading">
            <h6>
              Useful External Links
            </h6>
          </div>
          <ul class="nav nav-pills flex-column">
              <li class="nav-item">
                  <a class="nav-link text-white" href="https://logon.slc.co.uk/welcome/secured/login?_locale=en_GB&cookieConsent=accept" target="_blank">
                      <i class="fas fa-university"></i>
                      Student Finance England
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-white" href="https://www.studentbeans.com/uk" target="_blank">
                      <i class="fas fa-tag"></i>
                      Student Beans
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-white" href="https://www.myunidays.com/GB/en-GB" target="_blank">
                      <i class="fas fa-graduation-cap"></i>
                      UniDAYS
                  </a>
              </li>
          </ul>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Script to add 'active' class to the current clicked sidebar link
    document.getElementById('sidebar').addEventListener('click', function(e) {
        const target = e.target.closest('.nav-link'); // Ensures the clicked element is a nav-link
        if (!target) return; // Ignores clicks that are not on nav-links

        // Remove 'active' class from all links
        document.querySelectorAll('.sidebar .nav-link').forEach(link => link.classList.remove('active'));

        // Add 'active' class to the clicked link
        target.classList.add('active');
    });
</script>