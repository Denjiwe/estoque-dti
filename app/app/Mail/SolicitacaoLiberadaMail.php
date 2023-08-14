<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Solicitacao;

class SolicitacaoLiberadaMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $solicitacao;
    public $nome;
    public $saudacao;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Solicitacao $solicitacao, $nome, $saudacao)
    {
        $this->solicitacao = $solicitacao;
        $this->nome = $nome;
        $this->saudacao = $saudacao;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $id = $this->solicitacao->id;
        return new Envelope(
            subject: "Solicitacão #$id Liberada!",
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            text: 'solicitacao.liberada',
            with: [
                'saudacao' => $this->saudacao,
                'id' => $this->solicitacao->id,
                'nome' => $this->nome,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
