<?php

require 'vendor/autoload.php';

use PHPSandbox\Repl\OutputModifiers\OutputModifier;
use PHPSandbox\Repl\Repl;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\VarDumper\Caster\Caster;

class Inspiring
{
    /**
     * Get an inspiring quote.
     *
     * Taylor & Dayle made this commit from Jungfraujoch. (11,333 ft.)
     *
     * May McGinnis always control the board. #LaraconUS2015
     *
     * RIP Charlie - Feb 6, 2018
     *
     * @return string
     */
    public static function quote()
    {
        $quotes = [
            'Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant',
            'An unexamined life is not worth living. - Socrates',
            'Be present above all else. - Naval Ravikant',
            'Happiness is not something readymade. It comes from your own actions. - Dalai Lama',
            'He who is contented is rich. - Laozi',
            'I begin to speak only when I am certain what I will say is not better left unsaid - Cato the Younger',
            'If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius',
            'It is not the man who has too little, but the man who craves more, that is poor. - Seneca',
            'It is quality rather than quantity that matters. - Lucius Annaeus Seneca',
            'Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci',
            'Let all your things have their places; let each part of your business have its time. - Benjamin Franklin',
            'No surplus words or unnecessary actions. - Marcus Aurelius',
            'Order your soul. Reduce your wants. - Augustine',
            'People find pleasure in different ways. I find it in keeping my mind clear. - Marcus Aurelius',
            'Simplicity is an acquired taste. - Katharine Gerould',
            'Simplicity is the consequence of refined emotions. - Jean D\'Alembert',
            'Simplicity is the essence of happiness. - Cedric Bledsoe',
            'Simplicity is the ultimate sophistication. - Leonardo da Vinci',
            'Smile, breathe, and go slowly. - Thich Nhat Hanh',
            'The only way to do great work is to love what you do. - Steve Jobs',
            'The whole future lies in uncertainty: live immediately. - Seneca',
            'Very little is needed to make a happy life. - Marcus Antoninus',
            'Waste no more time arguing what a good man should be, be one. - Marcus Aurelius',
            'Well begun is half done. - Aristotle',
            'When there is no desire, all things are at peace. - Laozi',
            'Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh',
            'Because you are alive, everything is possible. - Thich Nhat Hanh',
            'Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh',
            'Life is available only in the present moment. - Thich Nhat Hanh',
            'The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh',
        ];

        return $quotes[array_rand($quotes)];
    }
}

class InspireCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('inspire')
            ->setDefinition([])
            ->setDescription('Display an inspiring quote')
            ->setHelp('->setHelp');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln(Inspiring::quote());
    }
}

class TinkerCaster
{
    /**
     * Get an array representing the properties of a collection.
     *
     * @param  \Illuminate\Support\Collection  $collection
     * @return array
     */
    public static function castCollection($collection)
    {
        return [
            Caster::PREFIX_VIRTUAL . 'all' => $collection->all(),
        ];
    }
}

$commands = [new InspireCommand()];
$casters = [
    'Illuminate\Support\Collection' => 'TinkerCaster::castCollection',
];

$repl = new Repl(getcwd(), [new class() implements OutputModifier {
    public function modify(string $output = ''): string
    {
        return $output;
    }
}], $casters, $commands);

$repl->setCasters($casters);
$repl->setCommands($commands);

$code = file_get_contents('index.php');
$code = array_reverse(explode('<?php', $code, 2))[0];

echo $repl->execute($code);

exit;

