<?php

namespace App\Notifications;

use App\Models\Presupuesto;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PresupuestoTerminadoNotification extends Notification
{
    use Queueable;

    protected $presupuesto;
    protected $fabricanteNombre;

    public function __construct(Presupuesto $presupuesto, string $fabricanteNombre)
    {
        $this->presupuesto = $presupuesto;
        $this->fabricanteNombre = $fabricanteNombre;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Presupuesto Nro ' . $this->presupuesto->numero . ' - Listo para retirar')
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line('El presupuesto **Nro ' . $this->presupuesto->numero . '** del cliente **' . $this->presupuesto->cliente_nombre . '** ha sido marcado como **Terminado** por el fabricante **' . $this->fabricanteNombre . '**.')
            ->line('El pedido ya esta listo para retirar.')
            ->action('Ver en Ventas', url('/dashboard/ventas'))
            ->line('Gracias por usar ALU Cristales Palermo.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'presupuesto_id' => $this->presupuesto->id,
            'presupuesto_numero' => $this->presupuesto->numero,
            'cliente_nombre' => $this->presupuesto->cliente_nombre,
            'fabricante_nombre' => $this->fabricanteNombre,
            'mensaje' => 'El presupuesto Nro ' . $this->presupuesto->numero . ' del cliente ' . $this->presupuesto->cliente_nombre . ' esta listo para retirar.',
        ];
    }
}
