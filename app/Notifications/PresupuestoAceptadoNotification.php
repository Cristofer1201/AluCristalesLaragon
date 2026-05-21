<?php

namespace App\Notifications;

use App\Models\Presupuesto;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PresupuestoAceptadoNotification extends Notification
{
    use Queueable;

    protected $presupuesto;
    protected $trabajadorNombre;

    public function __construct(Presupuesto $presupuesto, string $trabajadorNombre)
    {
        $this->presupuesto = $presupuesto;
        $this->trabajadorNombre = $trabajadorNombre;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nuevo presupuesto aceptado - Nro ' . $this->presupuesto->numero)
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line('El presupuesto **Nro ' . $this->presupuesto->numero . '** del cliente **' . $this->presupuesto->cliente_nombre . '** ha sido **aceptado** por el trabajador **' . $this->trabajadorNombre . '**.')
            ->line('Ya puedes comenzar con la fabricacion.')
            ->action('Ver en Ventas', url('/dashboard/ventas'))
            ->line('Gracias por usar ALU Cristales Palermo.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'presupuesto_id' => $this->presupuesto->id,
            'presupuesto_numero' => $this->presupuesto->numero,
            'cliente_nombre' => $this->presupuesto->cliente_nombre,
            'trabajador_nombre' => $this->trabajadorNombre,
            'mensaje' => 'Nuevo presupuesto aceptado Nro ' . $this->presupuesto->numero . ' del cliente ' . $this->presupuesto->cliente_nombre . '. Listo para fabricar.',
        ];
    }
}
