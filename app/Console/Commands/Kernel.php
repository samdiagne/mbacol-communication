protected function schedule(Schedule $schedule)
{
    $schedule->command('sitemap:generate')->daily();
}