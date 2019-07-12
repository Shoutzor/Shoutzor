<div class="page-content">
  <div class="container">
    <div class="row">
      <div class="col col-login mx-auto">
        <form class="card" action="/resetpassword" method="post">
          <div class="card-body p-6">
            <div class="card-title text-center">Reset password</div>
            {{ flash.output() }}
            <div class="form-group">
              <label class="form-label">Email</label>
              <input type="text" class="form-control" placeholder="Enter email">
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary btn-block">Send instructions</button>
            </div>
          </div>
        </form>
        <div class="text-center text-muted">
          Remember your password? <a href="/login">Login</a>
        </div>
        <div class="text-center text-muted">
          No account yet? <a href="/register">Register</a>
        </div>
      </div>
    </div>
  </div>
</div>
