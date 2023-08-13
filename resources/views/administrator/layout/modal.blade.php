@include('administrator.layout.modal.resetPassword')

@include('administrator.layout.modal.resetPIN')

@include('administrator.layout.modal.profile')

@include('administrator.layout.modal.setting')

@include('administrator.layout.modal.inbox')


@push('js')
<script type="text/javascript">
  $(document).ready(function() {
    $(".toggle-password").click(function() {
      var targetInput = $($(this).data("target"));
      var icon = $(this).find("i");
      
      if (targetInput.attr("type") === "password") {
        targetInput.attr("type", "text");
        icon.removeClass("fa-eye").addClass("fa-eye-slash");
      } else {
        targetInput.attr("type", "password");
        icon.removeClass("fa-eye-slash").addClass("fa-eye");
      }
    });
  });
</script>


@stack('modaljs')

@endpush