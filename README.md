<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h1 align="center">COVID vaccine registration system</h1>


### Installation Instructions

Follow these steps to set up and run the Laravel application:

1. **Clone the repository:**
    ```bash
    git clone https://github.com/tarikmanoar/covid-vaccine-registration.git
    cd covid-vaccine-registration
    ```

2. **Install dependencies:**
    ```bash
    composer install
    ```

3. **Install Node dependencies:**
    ```bash
    npm install && npm run build
    ```

4. **Copy the `.env` file:**
    ```bash
    cp .env.example .env
    ```

5. **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

6. **Configure your database:**

    Open the `.env` file and update the following lines with your database information:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

7. **Run database migrations:**
    ```bash
    php artisan migrate
    ```

8. **Start the development server:**
    ```bash
    php artisan serve
    ```

9. **Access the application:**

    Open your web browser and navigate to `http://localhost:8000`.

COVID vaccine registration system application should now be up and running.


## Additional requirement of sending ‘SMS’ notification

To send SMS notifications along with email notifications, we will use Vonage (formerly known as Nexmo). Follow these steps to set up SMS notifications:


1. **Install the Vonage library:**
    ```bash
    composer require laravel/vonage-notification-channel guzzlehttp/guzzle
    ```

2. **Set up Vonage configuration:**

    Add your Vonage API credentials to your `.env` file:
    ```env
    VONAGE_KEY=your_vonage_api_key
    VONAGE_SECRET=your_vonage_api_secret
    VONAGE_SMS_FROM=your_vonage_virtual_number
    ```

3. **Create a notification class (If not exists):**

    Use the Artisan command to create a new notification class:
    ```bash
    php artisan make:notification VaccinationReminder
    ```

4. **Configure the notification class:**

    Open the newly created `VaccinationReminder` notification class in `app/Notifications/VaccinationReminder.php` and update it to include the `toVonage` method:
    ```php
    <?php

    namespace App\Notifications;

    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Notification;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Messages\VonageMessage;

    class VaccinationReminder extends Notification
    {
        use Queueable;

        public function __construct()
        {
            //
        }

        public function via($notifiable)
        {
            return ['vonage', 'mail'];
        }

        public function toMail(object $notifiable): MailMessage
        {
            return (new MailMessage)
                ->subject('Your vaccination is scheduled for tomorrow.')
                ->greeting('Hello, '.$notifiable->name)
                ->line('This is a reminder that your vaccination is scheduled for tomorrow.')
                ->action('View Details', url('/'))
                ->line('Thank you for using our application!');
        }

        public function toVonage($notifiable)
        {
            return (new VonageMessage)
                        ->content('Your vaccination is scheduled for tomorrow.');
        }
    }
    ```

5. **Route notifications:**

    Ensure your `User` model (or any other notifiable model) includes a `routeNotificationForVonage` method to route the notifications to the correct phone number:
    ```php
    <?php

    namespace App\Models;

    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class User extends Authenticatable
    {
        use Notifiable;

        public function routeNotificationForVonage($notification)
        {
            return $this->phone;
        }
    }
    ```

6. **Trigger the notification:**

    You can now trigger the notification from anywhere in your application. For example, you might trigger it when an invoice is paid:
    ```php
    use App\Notifications\VaccinationReminder;
    use App\Models\User;

    $user = User::find(1);
    $user->notify(new VaccinationReminder());
    ```

With these steps, your application will be able to send SMS notifications using Vonage.


With these steps, your application will be able to send SMS notifications using Twilio.
