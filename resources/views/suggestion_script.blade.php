<script type="text/javascript">
    let isAccepted = confirm("Would you like to leave a feedback?");
    if (isAccepted)
    {
        let url = new URL("{{ route('appeal') }}");
        url.searchParams.append('suggested', '1');
        window.location.href = url;
    }
</script>
