<?php
namespace TopicDistribution;

use DateTime;

class TopicDistribution {
    public function __construct(
            public int       $student_id,
            public int       $topic_id,
            public ?DateTime $assigned_at
    ) {}
}