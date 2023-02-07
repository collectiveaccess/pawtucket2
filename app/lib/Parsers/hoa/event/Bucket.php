<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2017, Hoa community. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace Hoa\Event;

/**
 * Class \Hoa\Event\Bucket.
 *
 * This class is the object which is transmit through event channels.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Bucket
{
    /**
     * Source object.
     *
     * @var \Hoa\Event\Source
     */
    protected $_source = null;

    /**
     * Data.
     *
     * @var mixed
     */
    protected $_data   = null;



    /**
     * Set data.
     *
     * @param   mixed   $data    Data.
     */
    public function __construct($data = null)
    {
        $this->setData($data);

        return;
    }

    /**
     * Send this object on the event channel.
     *
     * @param   string             $eventId    Event ID.
     * @param   \Hoa\Event\Source  $source     Source.
     * @return  void
     */
    public function send($eventId, Source $source)
    {
        return Event::notify($eventId, $source, $this);
    }

    /**
     * Set source.
     *
     * @param   \Hoa\Event\Source  $source    Source.
     * @return  \Hoa\Event\Source
     */
    public function setSource(Source $source)
    {
        $old           = $this->_source;
        $this->_source = $source;

        return $old;
    }

    /**
     * Get source.
     *
     * @return  \Hoa\Event\Source
     */
    public function getSource()
    {
        return $this->_source;
    }

    /**
     * Set data.
     *
     * @param   mixed   $data    Data.
     * @return  mixed
     */
    public function setData($data)
    {
        $old         = $this->_data;
        $this->_data = $data;

        return $old;
    }

    /**
     * Get data.
     *
     * @return  mixed
     */
    public function getData()
    {
        return $this->_data;
    }
}
